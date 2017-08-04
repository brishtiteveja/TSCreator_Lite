<?php
class Path {
	
	private $paths;
	private $file_root;
	private $web_root;
	private static $cur_obj = false;

	// Now this object is made only once and I don't have to keep track of it...
	public static function get() {
		if( self::$cur_obj === false )
			self::$cur_obj = new Path();

		return self::$cur_obj;
	}

  function __construct() {
    $this->paths = array( 
      // Classes
      "class_page"      	=> "include/Page/class_page.php",
      "class_errorcheck"	=> "include/ErrorCheck/class_errorcheck.php",
			"class_log"					=> "include/Logging/class_log.php",
			"class_datapack"		=> "include/Datapack/class_datapack.php",
			"class_mappack"			=> "include/Mappack/class_mappack.php",
      "class_image"    		=> "include/Image/class_image.php",
			"class_chart"				=> "include/Chart/class_chart.php",
			"class_database" 		=> "include/Database/class_database.php",

      // Functions
      "image_gen" => "include/Image/image.php",

      // Other Pages
      "page_datapack_help"      	=> "test.php",
      "page_tutorial"           	=> "test.php",
      "page_time_interval_help" 	=> "test.php",
      "page_tscreator_lite_help"	=> "test.php",
      "page_start_age_help"     	=> "test.php",
      "page_end_age"            	=> "test.php",
      "page_vertical_scale"				=> "test.php",
			"page_index"								=> "site/index/index.php",
			"page_configure"						=> "site/configure/configure.php",
			"page_configure_map_image"	=> "site/configure/map_image.php",
			"page_configure_enable_image" => "site/configure/enable_image.php",
			"page_generate"							=> "site/generate/generate.php",
			"page_chart"								=> "site/chart/chart.php",
			"page_chart_display"				=> "site/chart/display.php",

      // Base Directory
      "basedir_images" 				=> "datapacks/",
      "datapacks"      				=> "datapacks/",
      "SpryAssets"    				=> "site/global/SpryAssets/",
      "CSS"            				=> "site/global/css/",
      "Icons"          				=> "site/global/icons/",
      "basedir_chart_request" => "/web/groups/strat/private/tsclite/server_new_settings/",
      "basedir_chart"         	=> "/web/groups/strat/private/tsclite/server_pdf_output/",

      // CSS
      "css_mainsheet"             => "site/global/css/oneColElsCtrHdr.css",
      "css_main"             			=> "site/global/css/main.css",
      "css_SpryMenuBarHorizontal" => "site/global/SpryAssets/SpryMenuBarHorizontal.css",
			"css_configure"							=> "site/configure/css/configure.css",
			"css_jQuery_ui"							=> "site/global/css/jquery-ui-1.8.20.custom.css",

			// JS
			"js_SpryMenuBar"	=> "site/global/SpryAssets/SpryMenuBar.js",
			"js_jQuery"				=> "site/global/js/jquery-1.7.2.min.js",
			"js_jQuery_ui"		=> "site/global/js/jquery-ui-1.8.20.custom.min.js",
			"js_jQuery_ui_tap"=> "site/global/js/jquery.ui.touch-punch.min.js",

			// Images
			"enable_image_on" => "site/configure/images/green_dot.png",
			"enable_image_off" => "site/configure/images/red_dot.png",
			"enable_image_disabled" => "site/configure/images/grey_dot.png",

      // GIF
			"gif_SpryMenuBarDownHover" => "site/global/SpryAssets/SpryMenuBarDownHover.gif",
			"gif_SpryMenuBarRightHover" => "site/global/SpryAssets/SpryMenuBarRightHover.gif",
      "gif_header" => "site/global/images/TSCreator_Header.gif",
      "man_anim" => "site/global/images/man_anim.gif",
			"gif_man" => "site/global/images/5man.gif",

      // ICONS
      "icon_favicon" => "site/global/icons/favicon.ico",

      // Templates
      "template_index_form"     => "templates/index_form.php",
      "template_index_png"      => "templates/index_png.php",
      "template_showpdf"        => "templates/header_showpdf.php",
      "template_showpng"        => "templates/header_showpng.php",
      "template_wait"           => "templates/wait.php",
      "template_header_wait"    => "templates/header_wait.php",
      "template_header_error"   => "templates/header_error.php",
      "template_header_timeout" => "templates/header_timeout.php",
      "template_timeout"        => "templates/timeout.php", 

      "template_header"         => "templates/header.tpl",
      "template_footer"         => "templates/footer.tpl",
			"template_index"					=> "templates/index.tpl",
			"template_configure"			=> "templates/configure.tpl",
			"template_generate"				=> "templates/generate.tpl",
			"template_chart"					=> "templates/chart.tpl",

			// Settings files
			"settings_datapacks"				=> "datapacks/datapack.xml"

      );

    $this->file_root = dirname(__FILE__) . "/../../";
	// Let this software work under any username based hosting (mainly in test environment)
    if (preg_match("#^/~(\w+)#", $_SERVER[PHP_SELF], $matches)) {
      $this->web_root = "/~{$matches[1]}/";
    } else {
			$this->web_root = dirname($_SERVER["PHP_SELF"]) . '/../';
      //$this->web_root = "/";
    }
  }

  function getFilePath($path) {
    if (!array_key_exists($path, $this->paths)) {
        ?><h1>ERROR: path <?=$path?> DOES NOT EXIST!!!!!</h1><?
      }
		
			if( substr( $this->paths[$path], 0, 1 ) == '/' )
				// Path given as absolute
				return $this->paths[$path];
			else
				// Path given as relative to tsclite base
      	return $this->file_root . $this->paths[$path];
    }

  function getWebPath($path) {
    if (!array_key_exists($path, $this->paths)) {
      ?><h1>ERROR: path <?=$path?> DOES NOT EXIST!!!!!</h1><?
    }

    return $this->web_root . substr($this->paths[$path], 5);
  }

}

