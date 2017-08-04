<?php
class Datapack {

	public $name;
	public $default;
	public $directory;
	public $svg;
	public $png;
	public $mappack_file;
	
	private $mappack = false;

	private static $default_datapack = false;
	private static $datapacks = false;

	public function __construct( $name )
	{
		$file = Path::get()->getFilePath( "settings_datapacks" );

		if( !file_exists( $file ) )
				Log::doLog( "Could not find installed datapacks settings file", true );

		$settings = simplexml_load_file( $file );

		self::$datapacks = array();
		foreach( $settings->datapack as $datapack )
		{
			self::$datapacks[] = array( "name" 		=> $datapack->name->__toString(),
																	"default"	=> $datapack->default->__toString() );
			
			if( $datapack->default == "true" )
				self::$default_datapack = $datapack->name->__toString();

			if( $datapack->name == $name )
			{
				$this->name 				= $datapack->name->__toString();
				$this->default 			= $datapack->default->__toString();
				$this->directory		= $datapack->directory->__toString();
				$this->svg					= $datapack->svg->__toString();
				$this->svg_path			= Path::get()->getFilePath("datapacks") . "/{$this->directory}/{$datapack->svg}";
				$this->png 					= $datapack->png->__toString();
				$this->png_path			= Path::get()->getFilePath("datapacks") . "/{$this->directory}/{$datapack->png}";
				$this->mappack_path	= Path::get()->getFilePath("datapacks") . "/{$this->directory}/{$datapack->mappack}";
			}
		}
	}

	public function __get( $name )
	{
		switch( $name )
		{
			case "mappack":
				if( $this->mappack === false )
					$this->mappack = new Mappack( $this->mappack_path );

				return $this->mappack;
			break;
		}
	}

	public static function get_datapacks(  ) 
	{
		if( self::$datapacks !== false )
			return self::$datapacks;

		$file = Path::get()->getFilePath( "settings_datapacks" );

		if( !file_exists( $file ) )
				Log::doLog( "Could not find installed datapacks settings file", true );

		// Load settings file
		$settings = simplexml_load_file( $file );

		self::$datapacks = array();
		foreach( $settings->datapack as $datapack )
		{
			$tmp['name'] = $datapack->name->__toString();
			$tmp['default'] = $datapack->default->__toString();

			// fill in static array
			self::$datapacks[] = $tmp;
		}

		return self::$datapacks;
	}	

}
