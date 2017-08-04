<?php

if( empty( $_GET["filename"] ) )
	die("pending1");

if( file_exists( trim("/web/groups/strat/private/tsclite/server_pdf_output/{$_GET['filename']}") ) )
	die("done");

die("pending");
