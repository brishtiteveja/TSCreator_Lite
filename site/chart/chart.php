<?php
require_once(realpath(dirname(__FILE__) . "/../../include/header.php"));

$page = new Page();
$page->assign( "title", "Your Chart");

$page->assign("pdf", array( ) );
$page->assign("png", array( ) );

if( !Chart::chart_exists_filename( $_GET['filename'] ) )
	Log::doLog( "Unknown file name" );

$page->assign( "svg", array() );
$page->assign( "png", array() );
$page->assign( "pdf", array() );

$filename = Path::get()->getWebPath("page_chart_display") . "?filename={$_GET['filename']}";

switch( substr( $_GET['filename'], -3, 3 ) )
{
	case 'svg':
		$page->assign( "svg", array( $filename ) );
	break;

	case 'png':
		$page->assign( "png", array( $filename ) );
	break;

	case 'pdf':
		$page->assign( "pdf", array( $filename ) );
	break;

	default:
		Log::doLog( "Not a support file format: " . substr( $_GET['filename'], -3, 3) );
	break;
}

$page->assign( "chart_download", array($filename));

$page->output( "chart" ) ;
