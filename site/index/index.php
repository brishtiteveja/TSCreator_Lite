<?php
require_once(realpath(dirname(__FILE__) . "/../../include/header.php"));

$page = new Page();

$page->assign("title", "Configure Chart");

// Reset to defaults
if( isset($_GET["load_defaults"]) && $_GET["load_defaults"] == "true")
{
	$_SESSION["event_col_bg"] = "false";
	$page->assign("load_defaults", "true" );
} else {
	$page->assign("load_defaults", "false" );
}

if( isset($_SESSION["format"]) && $_GET["load_defaults"] != "true" )
{
	$page->assign("curr_format", $_SESSION["format"] );
} else {
	$page->assign("curr_format", "svg" );
}

// make the config page
$page->assign("start_age", "" );
$page->assign("end_age", "" );
$page->assign("vertical_scale", "" );

$page->assign("format", array( 	"svg" => "SVG",
																"png" => "PNG",
																"pdf" => "PDF" ) );

$datapacks = Datapack::get_datapacks();

foreach( $datapacks as &$datapack )
{
	if( $datapack["default"] == "true" )
		$datapack["default"] = "default";
	else
		$datapack["default"] = "";
}

if( isset($_SESSION["chart_popup"]) && $_SESSION["chart_popup"] == 1 )
  $page->assign("chart_popup", array("checked"));
else
  $page->assign("chart_popup", array());

if( isset($_SESSION["event_col_bg"]) && $_SESSION["event_col_bg"] == 1 )
  $page->assign("event_col_bg", array("checked"));
else
  $page->assign("event_col_bg", array());

$page->assign("datapacks", $datapacks );

$page->output("index");
