<?php
require_once(realpath(dirname(__FILE__) . "/../../include/header.php"));

if( !Chart::chart_exists_filename( $_GET['filename'] ) )
	Log::doLog( "Unknown file name" );

header( "Content-Type: " . Chart::get_mime_type( $_GET['filename'] ) );

if( isset($_GET["as_download"]) )
{
  $ext = substr($_GET["filename"], -3, 3);
	header( "Content-Disposition: attachment; filename=\"TSClite Chart.{$ext}\"" );
}

echo Chart::get_chart( $_GET['filename'] );

die();
