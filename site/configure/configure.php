<?php
require_once(realpath(dirname(__FILE__) . "/../../include/header.php"));

$datapack = new Datapack( $_GET["datapack"] );
$mappack = &$datapack->mappack;

//////
// INPUT LOGIC
//////

// Update the request image map type
if( isset($_GET["map_image_type"]) &&  ErrorCheck::get()->check_map_image_type( $_GET["map_image_type"] ) )
	$_SESSION["map_image_type"] = $_GET["map_image_type"];

// If we do not have a session make one
if( !isset($_SESSION["start_age"]))
	$_GET["load_defaults"] = true;

// Reset to defaults
if( isset($_GET["load_defaults"]) && $_GET["load_defaults"] == "true")
{
	$_SESSION["start_age"] = $mappack->default_age["top_age"];
	$_SESSION["end_age"] = $mappack->default_age["base_age"];
	$_SESSION["vertical_scale"] = $mappack->default_age["vertical_scale"];
	$_SESSION["event_col_bg"] = "false";

	$dp = new Datapack( $_GET["datapack"] );
		
	foreach( $dp->mappack->datacols as $dc )
	{
		unset($_SESSION["columns"][ $dc["name"] ]);
	}
}

//////
// PAGE GENERATION
//////

$page = new Page();

// No header and footer, everything here gets ajax'd in
$page->has_header = false;
$page->has_footer = false;

// Put in default ages
if( isset($_SESSION["start_age"]) && isset($_SESSION["end_age"]) && isset( $_SESSION["vertical_scale"] ) )
{
	$page->assign("current_start_age", $_SESSION["start_age"] );
	$page->assign("current_end_age", $_SESSION["end_age"] );
	$page->assign("current_vertical_scale", $_SESSION["vertical_scale"] );
} else {
	$page->assign("current_start_age", $mappack->default_age["top_age"] );
	$page->assign("current_end_age", $mappack->default_age["base_age"] );
	$page->assign("current_vertical_scale", $mappack->default_age["vertical_scale"] );
}

$page->assign("default_start_age", $mappack->default_age["top_age"] );
$page->assign("default_end_age", $mappack->default_age["base_age"] );
$page->assign("default_vertical_scale", $mappack->default_age["vertical_scale"] );
if( isset($_GET["popup_checked"]) && $_GET["popup_checked"] == 1 )
  $page->assign("configure_popup", array("checked"));
else
  $page->assign("configure_popup", array());

if( isset($_GET["event_col_bg"]) && $_GET["event_col_bg"] == 1 )
  $page->assign("event_col_bg", array("checked"));
else
  $page->assign("event_col_bg", array());

$png = $svg = $map = array();

// Put the image map on the page
switch( $_SESSION["map_image_type"] )
{
	case "svg":
		$img = simplexml_load_file( $datapack->svg_path );

		// Build the image for display
		$t["src"] = Path::get()->getWebPath("page_configure_map_image") . "?datapack={$datapack->name}&type=svg";
		$t["width"] = (int)($img->attributes()->width);
		$t["height"] = (int)($img->attributes()->height);
		$svg[] = $t; // Weird, but uses the templates loop structure to delete the png or svg html if not in use
	break;

	default:
	case "png":
		// Build the image for display
		$t["src"] = Path::get()->getWebPath("page_configure_map_image") . "?datapack={$datapack->name}&type=png";
		list( $t["width"], $t["height"] ) = getimagesize( $datapack->png_path );

		$png[] = $t; // Weird, but uses the templates loop structure to delete the png or svg html if not in use

		// Find scale factor for dot cordinates
		$xscale = $png[0]["width"] / ($mappack->coordinate["lower_right_lon"] - $mappack->coordinate["upper_left_lon"]);
		$yscale = $png[0]["height"] / ($mappack->coordinate["lower_right_lat"] - $mappack->coordinate["upper_left_lat"]);

		$datacols = array();
		$map = array();

		// Make image map for datacols
		foreach( $mappack->datacols as $i => $datacol )
		{
			$map[] = array( "note"  => htmlspecialchars ( $datacol["note"] ),
											"href"  => "#",
											"id" 		=> "datapoint_{$i}",
											"x"			=> ($datacol["lon"] - $mappack->coordinate["upper_left_lon"]) * $xscale,
											"y"			=> ($datacol["lat"] - $mappack->coordinate["upper_left_lat"]) * $yscale );
		}
	break;
}

// Place SVG or PNG image down
$page->assign( "map_image_svg", $svg );
$page->assign( "map_image_png", $png );
$page->assign( "img_map", $map );

// Make table for datacols
foreach( $mappack->datacols as $i => $datacol )
{
	$datacols[] = array( "name" => $datacol["name"],
											 "notes"	=> str_replace("\"\"", "\"", $datacol["note"]),
											 "id" 		=> "datapoint_{$i}",
											 "min"    => $datacol["min"],
											 "max"    => $datacol["max"],
											 "enable_image" => Path::get()->getWebPath( "page_configure_enable_image" ) . "?enable=" . Image::get()->get_column_state( $datacol ) );

}

// Place table down
$page->assign("datacols", $datacols);

// Put down required javascript


$page->output("configure");
