<?php
require_once(realpath(dirname(__FILE__) . "/../../include/header.php"));

$green = array( 1, 255, 1 );
$red = array( 255, 1, 1 );
$grey = array( 195, 195, 195 );

$datapack = new Datapack( $_GET["datapack"] );
$mappack = &$datapack->mappack;

$image_file = Path::get()->getFilePath( "datapacks" ) . "/" . $pack["map_image"];

if( $_GET["type"] == "svg" )
{
	$xml = simplexml_load_file( $datapack->svg_path );
	
	// get rid of unneeded (large) illustrator binary crap...
	unset($xml->children('i', true)->pgf);

	// Find the image size
	$img_width = (int)($xml->attributes()->width);
	$img_height = (int)($xml->attributes()->height);

	// Add some css (used later for UI)
	$style = "circle { z-index: 2; } circle.clear { fill: #ffffff; fill-opacity:0; stroke: none; }\n". 
					 "circle.on { stroke: #000000; fill: rgb( {$green[0]}, {$green[1]}, {$green[2]} ) }\n" .
					 "circle.off { stroke: #000000; fill: rgb( {$red[0]}, {$red[1]}, {$red[2]} ) }\n" .
					 "circle.disabled { stroke: #000000; fill: rgb( {$grey[0]}, {$grey[1]}, {$grey[2]} ) }";
	$style .= "line { z-index: 1; stroke-width: 6; } " .
			  "line.clear { stroke: #000000; stroke-width: 8; }\n". 
					 "line.on { stroke: rgb( {$green[0]}, {$green[1]}, {$green[2]} ) }\n" .
					 "line.off { stroke: rgb( {$red[0]}, {$red[1]}, {$red[2]} ) }\n" .
					 "line.disabled { stroke: rgb( {$grey[0]}, {$grey[1]}, {$grey[2]} ) }";
	$style = $xml->addChild( "style", $style );
	$style->addAttribute( "type", "text/css" );

	// Embed the active logic
	$script = file_get_contents( "svg.js" );
	$script = $xml->addChild( "script", $script );
	$script->addAttribute( "type", "text/ecmascript" );

	// Add the dots to the image
	$g = $xml->addChild( "g" );
	$g->addAttribute( "id", "Dots" );

	foreach($mappack->datacols as $i => $datapoint){

		if($datapoint["type"] == "datacol") {
			$xy = get_xy($datapoint, $mappack, $img_width, $img_height);
			$x = $xy[0];
			$y = $xy[1];

			$elm = $g->addChild( "circle" );
			$elm->addAttribute( "cx", $x );
			$elm->addAttribute( "cy", $y );
			$elm->addAttribute( "r", "9" );
			$elm->addAttribute( "id", "datapoint_{$i}_point" );

			// Color the dots based on age, session, and settings data
			$elm->addAttribute( "class", Image::get()->get_column_state( $datapoint ) );

			$elm = $g->addChild( "circle" );
			$elm->addAttribute( "onclick", "handle_dot_click( evt )" );
			$elm->addAttribute( "cx", $x );
			$elm->addAttribute( "cy", $y );
			$elm->addAttribute( "r", "17" );
			$elm->addAttribute( "id", "datapoint_{$i}" );
			$elm->addAttribute( "onmouseover", "handle_dot_over( evt )" );
			$elm->addAttribute( "onmouseout", "handle_dot_out( evt )" );
			$elm->addAttribute( "class", "clear" );

		} else if($datapoint["type"] == "transect") {

			$start = false;
			$end = false;
			foreach($mappack->datacols as $col) {
				if($col["name"] == $datapoint["startloc"]) {
					$start = $col;
				}

				if($col["name"] == $datapoint["endloc"]) {
					$end = $col;
				}
			}

			if(!$start || !$end) 
				continue;

			$start_xy = get_xy($start, $mappack, $img_width, $img_height);
			$end_xy = get_xy($end, $mappack, $img_width, $img_height);

			$dom = dom_import_simplexml($g);

			$elm = $dom->insertBefore($dom->ownerDocument->createElement("line"), $dom->firstChild);

			$elm = simplexml_import_dom($elm, "SimpleXMLElement");

//			$elm = $g->addChild("line");
			$elm->addattribute("x1", $start_xy[0]);
			$elm->addattribute("y1", $start_xy[1]);
			$elm->addattribute("x2", $end_xy[0]);
			$elm->addattribute("y2", $end_xy[1]);
			$elm->addAttribute( "class", Image::get()->get_column_state( $datapoint ) );
			$elm->addAttribute( "id", "datapoint_{$i}_line" );
			$elm->addAttribute( "onclick", "handle_dot_click( evt )" );

			$dom = dom_import_simplexml($g);

			$elm = $dom->insertBefore($dom->ownerDocument->createElement("line"), $dom->firstChild);

			$elm = simplexml_import_dom($elm, "SimpleXMLElement");

			$elm->addattribute("x1", $start_xy[0]);
			$elm->addattribute("y1", $start_xy[1]);
			$elm->addattribute("x2", $end_xy[0]);
			$elm->addattribute("y2", $end_xy[1]);
			$elm->addAttribute( "class", "clear");
		}

	}

	header("Content-Type: image/svg+xml");
	echo $xml->asXml();

// PNG mode
} else {
	$img = imagecreatefrompng( $datapack->png_path );

	$green_ellipse = imagecolorallocate($img, $green[0], $green[1], $green[2] );
	$red_ellipse   = imagecolorallocate($img, $red[0], $red[1], $red[2] );
	$grey_ellipse = imagecolorallocate($img, $grey[0], $grey[1], $grey[2] );

	$img_width = imagesx($img);
	$img_height = imagesy($img);

	foreach($mappack->datacols as $datapoint){
		$xy = get_xy($datapoint, $mappack, $img_width, $img_height);
		$x = $xy[0];
		$y = $xy[1];
  
		// Color the dots based on age, session, and settings data
		switch( Image::get()->get_column_state( $datapoint ) )
		{
			case "on":
      	imagefilledellipse($img, $x, $y, 18, 18, $green_ellipse);
			break;

			case "off":
      	imagefilledellipse($img, $x, $y, 18, 18, $red_ellipse);
			break;

			case "disabled":
			default:
      	imagefilledellipse($img, $x, $y, 18, 18, $grey_ellipse);
			break;
		}

    imageellipse($img, $x, $y, 19, 19, $black_ellipse);
  }
  header('Content-type: image/png');
  imagepng($img);
  imagedestroy($img);
}

function get_xy($datapoint, $mappack, $width, $height) {
	if($mappack->coordinate["coord"] == "vertical") {
		$lonCenter = deg2rad($mappack->coordinate["center_lon"]);
		$latCenter = deg2rad($mappack->coordinate["center_lat"]);
		$lonPoint = deg2rad($datapoint["lon"]);
		$latPoint = deg2rad($datapoint["lat"]);
		$scale = $mappack->coordinate["scale"]; 

		$lonOffset = $lonPoint - $lonCenter;

		$P = ($height / 6371) + 1;
		$cosC = cos(sin($latCenter)*sin($latPoint) + sin($latCenter)*cos($latPoint)*cos($lonOffset));

		if($P != $cosC) {
			$K = ($P - 1)/($P - $cosC);
		} else {
			$K = 1;
		}

		$X = $K*(cos($latPoint)*sin($lonOffset))*6371;
		$Y = $K*(cos($latCenter)*sin($latPoint) - sin($latCenter)*cos($latPoint)*cos($lonOffset))*6371;

		$noOfPixPerKm = (0.4*$width)/$scale;

		$X = $X*$noOfPixPerKm;
		$Y = $Y*$noOfPixPerKm;

		$x = round(($width/2 + $X));
		$y = round(($height/2 - $Y));

	} else {
		$xscale = $width / ($mappack->coordinate["lower_right_lon"] - $mappack->coordinate["upper_left_lon"]);
		$yscale = $height / ($mappack->coordinate["lower_right_lat"] - $mappack->coordinate["upper_left_lat"]);

		$x = ($datapoint["lon"] - $mappack->coordinate["upper_left_lon"]) * $xscale;
		$y = ($datapoint["lat"] - $mappack->coordinate["upper_left_lat"]) * $yscale;
	}

	return array($x, $y);
}

?>
