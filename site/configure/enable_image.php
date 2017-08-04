<?php
// This gives the on, off, disabled images for the table before the map
require_once(realpath(dirname(__FILE__) . "/../../include/header.php"));

header("Content-Type: image/png");

if( !isset( $_GET["enable"] ) )
	$_GET["enable"] = "off";

switch( $_GET["enable"] )
{
	case "on":
		echo file_get_contents( Path::get()->getFilePath( "enable_image_on" ) );
	break;

	case "off":
		echo file_get_contents( Path::get()->getFilePath( "enable_image_off" ) );
	break;

	case "disabled":
	default:
		echo file_get_contents( Path::get()->getFilePath( "enable_image_disabled" ) );
	break;
}
