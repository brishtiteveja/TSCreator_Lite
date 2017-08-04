<?php
require_once(realpath(dirname(__FILE__) . "/../../include/header.php"));

if( !isset($_GET["action"]) )
	die();

switch( $_GET["action"] )
{
	// Update the state of a column
	case "column":
		if( !isset( $_GET["column"] ) || !isset( $_GET["state"] ) )
			die();

		if( !ErrorCheck::get()->check_map_image_state( $_GET["state"] ) )
			die();

		$datapack = new Datapack( $_GET["datapack"] );

		sscanf( $_GET["column"], "datapoint_%d", $i);

		$_SESSION["columns"][ $datapack->mappack->datacols[$i]["name"] ] = $_GET["state"];

	break;
}
