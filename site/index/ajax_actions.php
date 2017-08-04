<?php
require_once(realpath(dirname(__FILE__) . "/../../include/header.php"));

if( !isset($_GET["action"]) )
	die();

switch( $_GET["action"] )
{
	// Update the state of a column
	case "age":
		if( !is_numeric( $_GET["start_age"] ) || !is_numeric( $_GET["end_age"] ) )
			die( "err_missing_age" );

		if( !ErrorCheck::get()->age_check( $_GET["start_age"] ) )
			die( "err_bad_start_age" );

		if( !ErrorCheck::get()->age_check( $_GET["end_age"] ) )
			die( "err_bad_stop_age" );

		if( $_GET["end_age"] < $_GET["start_age"] )
			die( "err_end_before_start_age" );

		if( empty($_GET["vertical_scale"]) )
			die( "err_missing_vertical_scale" );

		if( !ErrorCheck::get()->vertical_scale( $_GET["vertical_scale"] ) )
			die( "err_bad_vertical_scale" );

		if( empty( $_GET["format"] ) || !ErrorCheck::get()->format( $_GET["format"] ) )
			die ( "err_bad_format" );

		$_SESSION["start_age"] = $_GET["start_age"];
		$_SESSION["end_age"] = $_GET["end_age"];
		$_SESSION["vertical_scale"] = $_GET["vertical_scale"];
		$_SESSION["format"] = $_GET["format"];

		die( "success" );
	break;

	case "clear_all":
		
		$_GET["column"] = ErrorCheck::get()->checkInput( $_GET["column"] );

		if( strlen( $_GET["column"] ) == 0 )
			Log::doLog( "You must provide a column to work on" );

		$dp = new Datapack( $_GET["column"] );
		
		foreach( $dp->mappack->datacols as $dc )
		{
			$_SESSION["columns"][ $dc["name"] ] = "off";
		}

		die( "success" );
	break;
}
