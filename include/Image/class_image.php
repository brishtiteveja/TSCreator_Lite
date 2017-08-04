<?php
// Use singleton pattern because these are mostly helper functions
class Image {

	private static $image = false;

  function __construct(){

  }

	public static function get()
	{
		if( self::$image === false )
			self::$image = new Image(); 

		return self::$image;
	}

	public function get_column_state( $datapoint )
	{
		if( $datapoint["min"] > $_SESSION["end_age"] || $datapoint["max"] < $_SESSION["start_age"] )
			return "disabled";
		elseif( isset( $_SESSION["columns"][$datapoint["name"]] ) )
			return $_SESSION["columns"][ $datapoint["name"] ] == "on" ? "on" : "off";
		else
			return $datapoint["default"] == "on" ? "on" : "off";
	}

}
