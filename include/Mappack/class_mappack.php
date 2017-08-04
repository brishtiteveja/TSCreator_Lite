<?php

class Mappack
{
		public $datacols;
		public $coordinate;
		public $map_info;
		public $parent_map; 
		public $default_age;
		public $transects;
		
		public function __construct( $mappack_file )
		{
			$this->datacols = array();
			$this->coordinate = null;
			$this->map_info = null;
			$this->parent_map = null;
			$this->default_age = null;

			$this->parse_pack( $mappack_file );
		}

		// Read in file and parse given mappack
		private function parse_pack( $file )
		{
			$lines = file( $file );

			foreach( $lines as $line )
			{
				$parts = explode( "\t", $line );

				// Clean up the data once now
				foreach( $parts as &$part )
					$part = trim( $part );

				// Pull out the data
				switch( strtolower( $parts[0] ) )
				{
					case "header-datacol":
					case "header-coord":
					case "header-parent map":
					case "header-map":
					case "header-map info":
					case "header-transects":
						$idx = $this->parse_header_col( $parts );
					break;

					case "datacol":
					 /* Format:
					 			0					1				2			 3						4							5					 6				7
							DATACOL -- NAME -- LON -- LAT -- DEFAULT ON/OFF -- MIN-AGE -- MAX-AGE -- NOTE
						*/
						/*$tmp = array();

						$tmp["name"]		= $parts[1];
						$tmp["lon"] 		= $parts[2];
						$tmp["lat"]		= $parts[3];
						$tmp["default"]		= $parts[4];
						$tmp["min"]		= $parts[5];
						$tmp["max"]		= $parts[6];
						$tmp["note"]		= $parts[7];*/

						$has = array("name", "lon", "lat", "default on/off", "min-age", "max-age", "note");
						$tmp = $this->get_col_vals( $has, $idx, $parts );
						$tmp["default"] = ( $tmp["default_on/off"] == "on" ? true : false );
						$tmp["type"] = "datacol";

						$this->datacols[] = $tmp;
					break;

					case "coord":
						/* Format:
								0							1									2									3									4										5
							COORD -- COORDINATE TYPE -- UPPER LEFT LON -- UPPER LEFT LAT -- LOWER RIGHT LON -- LOWER RIGHT LAT	
							  0             1               2             3           4         5
							
							OORD -- COORDINATE TYPE -- CENTER LAT -- CENTER LON -- HEIGHT -- SCALE  
						*/
						/*$tmp = array();

						$tmp["type"]						= $parts[1];
						$tmp["upper_left_lon"]	= $parts[2];
						$tmp["upper_left_lat"]	= $parts[3];
						$tmp["lower_right_lon"]	= $parts[4];
						$tmp["lower_right_lat"]	= $parts[5];*/

						$has = array("coordinate type", "center lat", "center lon", "height", "scale");
						$tmp = $this->get_col_vals( $has, $idx, $parts, true );
						$coord = "vertical";

						if($tmp === false) {
							$has = array("coordinate type", "upper left lon", "upper left lat", "lower right lon", "lower right lat");
							$tmp = $this->get_col_vals( $has, $idx, $parts );
							$coord = "rectangluar";
						} 

						$tmp["coord"] = $coord;

						$this->coordinate = $tmp;
					break;

					case "parent map":
						/* Format:
									0								1								2										3									4									5								6
							PARENT MAP -- PARENT NAME -- COORDINATE TYPE -- UPPER LEFT LON -- UPPER LEFT LAT -- LOWER RIGHT LON -- LOWER RIGHT LAT
						*/
						/*$tmp = array();

						$tmp["parent_name"]			= $parts[1];
						$tmp["coordinate_type"]	= $parts[2];
						$tmp["upper_left_lon"]	=	$parts[3];
						$tmp["upper_left_lat"]	= $parts[4];
						$tmp["lower_right_lon"]	= $parts[5];
						$tmp["lower_right_lat"] = $parts[6];*/

						$has = array("parent name", "coordinate type", "upper left lon", "upper left lat", "lower right lon", "lower right lat");
						$tmp = $this->get_col_vals( $has, $idx, $parts );

						$this->parent_map = $tmp;
					break;

			 		case "map info":
						/* Format:
									0					1						2				3
							MAP INFO -- MAP NAME -- IMAGE -- NOTE 
						*/
						/*$tmp = array();

						$tmp["map_name"] 	= $parts[1];
						$tmp["image"] 		= $parts[2];
						$tmp["note"]			= $parts[3];*/

						$has = array("map name", "image", "note");
						$tmp = $this->get_col_vals( $has, $idx, $parts );

						$this->map_info = $tmp;
					break;

					case "default ages":
						/* Format:
										0						1						2								3
							DEFAULT AGES -- TOP AGE -- BASE AGE -- VERTICAL SCALE
						*/
						/*$tmp = array();

						$tmp["top_age"] 				= $parts[1];
						$tmp["base_age"]	 			= $parts[2];
						$tmp["vertical_scale"]	= $parts[3];*/

						$has = array("top age", "base age", "vertical scale");
						$tmp = $this->get_col_vals( $has, $idx, $parts );

						$this->default_age = $tmp;
					break;

					case "map-version":
						/* Format:
									0							1
							MAP-VERSION -- VERSION
						*/

						$this->version = $parts[1];
					break;

					case "transect":
						/* Format:
										  0						 1			   2					3        4
							HEADER TRANSECTS -- NAME -- STARTLOC -- ENDLOC -- NOTE
						*/
						$has = array("name", "startloc", "endloc", "note");
						$tmp = $this->get_col_vals( $has, $idx, $parts );

						$start = $end = false;
						foreach( $this->datacols as $col ) {
								if($col["name"] == $tmp["startloc"]) {
									$start = $col;
								} else if ($col["name"] == $tmp["endloc"]) {
									$end = $col;
								}
						}

						if(!$start || !$end) {
							continue;
						}
						
						if($start["min"] < $end["min"])
							$tmp["min"] = $start["min"];
						else
							$tmp["min"] = $end["min" ];

						if($start["max"] > $end["max"])
							$tmp["max"] = $start["max"];
						else
							$tmp["max"] = $end["max" ];

						if($start["default_on/off"] || $end["default_on/off"])
							$tmp["default_on/off"] = true;
						else
							$tmp["default_on/off"] = false;

						$tmp["type"] = "transect";

						$this->datacols[] = $tmp;
					break;

					default:
						// Skip the line
					break;
				}
			}
		}

		private function parse_header_col( $parts )
		{
			$idx = array();
			foreach ( $parts as $i => $part )
				$idx[strtolower( $part )] = $i;

			return $idx;
		}

		private function get_col_vals( $has, $idx, $parts, $other_options = false )
		{
			if(sizeof(array_intersect(array_keys($idx), $has)) != sizeof($has)) {
				if(!$other_options) {
					Log::dolog("Malformed mappack or something like that", true);
				} else {
					return false;
				}
			}

			$tmp = array();
			foreach ( $has as $elm )
				$tmp[str_replace("-age", "", str_replace(" ", "_", $elm))] = $parts[$idx[$elm]];

			return $tmp;
		}
	}

