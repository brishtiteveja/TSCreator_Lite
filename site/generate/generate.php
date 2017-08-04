<?php
session_start();
set_include_path(get_include_path() . PATH_SEPARATOR . '/web/groups/strat/TSCreator_Website/lib/php/');
/*
include('Net/SSH2.php');

$ssh = new Net_SSH2('msee140lnx02.ecn.purdue.edu');
if (!$ssh->login('strat', 'qt2wQpJKiawRUj9V')) {
	exit('Password for ssh login is incorrect. Login Failed');
}

//echo "<pre>" + $_SESSION['TSCLITE_SERVER_STATUS'] + "</pre>";
if ($_SESSION['TSCLITE_SERVER_STATUS'] == 0)
{
	$output=$ssh->exec('sh /local/scratch/a/strat/tscreator/extra_resources/server_scripts/tsclite.sh stop');
	//echo "<pre>" + $output + "</pre>";
	$output_cron=$ssh->exec('sh /local/scratch/a/strat/tscreator/extra_resources/server_scripts/bash_cron.sh > /dev/null 2>&1 < /dev/null &');
	//echo "<pre>" + $output_cron + "</pre>";
	$_SESSION['TSCLITE_SERVER_STATUS'] = 1;
} else {
	$output = "Server already running.";
	echo "<pre>" + $output + "</pre>";
}
 */

require_once(realpath(dirname(__FILE__) . "/../../include/header.php"));


$db = false;
if( gethostname() == "templeton.ecn.purdue.edu" )
{
	// Establish a database connection
	$db = new Database();
}

// Put in user selection
if( isset($_GET["chart_popup"]) && $_GET["chart_popup"] == "on" )
		  $_SESSION["chart_popup"] = 1;
		else
		  $_SESSION["chart_popup"] = 0;

if( isset($_GET["event_col_bg"]) && $_GET["event_col_bg"] == "on" )
			$_SESSION["event_col_bg"] = 1;
		else
			$_SESSION["event_col_bg"] = 0;

if( is_array( $_SESSION["columns"] ) )
{
	foreach( $_SESSION["columns"] as $column => $value )
	{
		if( $value == "on" )
			$columns[$column] = "true";
		else
			$columns[$column] = "false";
	}
}

// Loop through the defaults and mark true to ones which are not marked by the user
$datapacks = Datapack::get_datapacks();
foreach( $datapacks as $datapack )
{
	$name = $datapack["name"];
	$datapack = new Datapack( $name );

	foreach( $datapack->mappack->datacols as $col )
	{
		if( empty($_SESSION["columns"][$col["name"]]) && $col["default"] )
			$columns[$col["name"]] = "true";
	}

	//// Quick hack for New Zeland demo ////
	if($name == "New Zealand") {
		foreach( $datapack->mappack->datacols as $col ) {
			if(array_key_exists($col["name"], $columns) && $columns[$col["name"]] === "true") {
				$columns["NZ Series"] = "true";
				$columns["NZ Substages"] = "true";
				$columns["NZ Abbrev."] = "true";
				break;
			}
		}
	}
	////////////////////////////////////////
}


if( empty( $_SESSION["format"] ) )
	$_SESSION["format"] = "svg";

$xml = Chart::generate_settings($_SESSION["start_age"], $_SESSION["end_age"], $_SESSION["vertical_scale"], 
												$_SESSION["format"], $columns, $_SESSION["chart_popup"], $_SESSION["event_col_bg"]);

$filename = Chart::generate_chart_name( $xml );

// If the chart is cached, move right to it
if( Chart::chart_exists( $filename, $_SESSION["format"] ) )
{
	if( $db )
	{
		// Update the databse to sho a cache hit
		$db->query(sprintf("INSERT INTO tsclite_gen_time ( id, name, type, request_time, finish_time, cache ) " .
							 "VALUES( NULL, '%s', '%s', NULL, NULL, 1 )",
							 $db->escape($filename),
							 $db->escape($_SESSION["format"] ) ) );
	}
	header( "Location: " . Path::get()->getWebPath("page_chart") . "?filename={$filename}.{$_SESSION["format"]}" );
	die();
}

// Start the create time of a chart
if( $db ) 
{
	$db->query(sprintf("INSERT INTO tsclite_gen_time ( id, name, type, request_time, finish_time, cache ) " .
						 "VALUES( NULL, '%s', '%s', NOW(), NULL, 0 )",
						 $db->escape( $filename ),
						 $db->escape( $_SESSION["format"] ) ) );
}

// Request the chart if we have no cache
Chart::request( $xml, $filename );

$page = new Page();
$page->assign("title", "Generating Chart" );

$page->assign("filename", "{$filename}.{$_SESSION['format']}" );

$page->output( 'generate' );
