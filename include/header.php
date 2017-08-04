<?php
require_once("/web/groups/strat/TSCreator_Lite/include/Page/class_path.php");

// Stop server scripts from starting a session
$sapi_type = php_sapi_name();
if( substr( $sapi_type, 0, 3 ) != 'cli' )
	session_start();

// Auto include functions, we need to at least hard code Path however
function __autoload( $class_name ) {
		require_once( realpath(Path::get()->getFilePath("class_" . strtolower($class_name) ) )) ;
}

?>
