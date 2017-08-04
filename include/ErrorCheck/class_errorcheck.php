<?php

class ErrorCheck {

	private static $error_check = false;

  function __construct(){
 	} 

	public static function get()
	{
		if( self::$error_check === false )
			self::$error_check = new ErrorCheck();

		return self::$error_check;
	}

	public function age_check( $age )
	{
		if( is_numeric( $age ) && $age >= 0 )
			return true;

		return false;
	}

	public function vertical_scale( $vert_scale )
	{
		if ( is_numeric( $vert_scale ) && $vert_scale > 0 )
			return true;

		return false;
	}

	public function format( $format )
	{
		$items = array( "png", "svg", "pdf" );

		if( in_array( strtolower($format), $items ) )
			return true;

		return false;
	}

	public function check_map_image_type( $type )
	{
		$items = array( "png", "svg" );

		if( in_array( $type, $items) )
			return true;

		return false;
	}

	public function check_map_image_state( $state )
	{
		$items = array( "on", "off", "disabled" );

		if( in_array( $state, $items ) )
			return true;

		return false;
	}

  /* Function to strip unwanted chars, strip any quotes escaped and pass it thru htmlspecialchars
   *
   *
   */
  function checkInput($value){
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
    return $value;
  }

  function checkInt($value){
         if (strlen($value) == 0)                       return "Error: field cannot be empty";
    else if (!filter_var($value , FILTER_VALIDATE_INT)) return "Error : Invalid int input ";
    else                                                return false;
  }

}

?>
