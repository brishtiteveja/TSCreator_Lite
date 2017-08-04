<?php

class Chart {
	
	public function __construct()
	{

	}

	public static function generate_settings($start_age, $end_age, $vertical_scale, $format, $columns, $popups, $event_col_bg)
	{
		$xml  = new SimpleXMLElement( '<settings />' );

		$k = $xml->addChild('keyval');
		$k->addAttribute("key", "TOP_AGE");
		$k->addAttribute("value", $start_age);

		$k = $xml->addChild('keyval');
		$k->addAttribute("key", "BASE_AGE");
		$k->addAttribute("value", $end_age);

		$k = $xml->addChild('keyval');
		$k->addAttribute("key", "VERTICAL_SCALE");
		$k->addAttribute("value", $vertical_scale);

		$k = $xml->addChild('keyval');
		$k->addAttribute("key", "FORMAT");
		$k->addAttribute("value", $format);
		
		$k = $xml->addChild('keyval');
		$k->addAttribute("key", "POPUPS");
		$k->addAttribute("value", $popups);

		$k = $xml->addChild('keyval');
		$k->addAttribute("key", "EN_EVENT_COL_BG");
		if($event_col_bg)
			$k->addAttribute("value", "true");
		else
			$k->addAttribute("value", "false");

		foreach( $columns as $column => $value )
		{
			$k = $xml->addChild('keyval');
			$k->addAttribute("key", $column);
			$k->addAttribute("value", $value );
		}

		return $xml->asXML();
	}

	public static function generate_chart_name( $xml )
	{
		return md5( $xml );
	}

	public static function chart_exists_filename( $filename )
	{
		$path = Path::get()->getFilePath( "basedir_chart" );

		return file_exists( "{$path}{$filename}" );
	}

	public static function chart_exists( $name, $format ) 
	{
		$path = Path::get()->getFilePath( "basedir_chart" );

		return file_exists( "{$path}{$name}.{$format}" );
	}	

	public static function get_mime_type( $name )
	{
		switch( substr( $name, -3, 3 ) )
		{
			case "svg":
				return "image/svg+xml";
			break;

			case "png":
				return "image/png";
			break;

			case "pdf":
				return "application/pdf";
			break;
		}
		
		return "";	
		//return mime_content_type( Path::get()->getFilePath( "basedir_chart" ) . $filename );
	}

	public static function get_chart( $filename )
	{
		return file_get_contents( Path::get()->getFilePath( "basedir_chart" ) . $filename );	
	}

	public static function request( $xml, $filename )
	{
		file_put_contents( Path::get()->getFilePath( "basedir_chart_request" ) . "{$filename}.xml", $xml );
	}

}
