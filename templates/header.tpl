<?php
if(!$prefix)
	$prefix="../../tscreator/";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title>TimeScale Creator Lite - {title}</title>
<link href="<?php echo Path::get()->getWebPath('icon_favicon'); ?>" rel="shortcut icon" />
<link href="<?php echo Path::get()->getWebPath('icon_favicon'); ?>" rel="icon" />
<link href="<?php echo Path::get()->getWebPath('css_mainsheet'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo Path::get()->getWebPath('css_main'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo Path::get()->getWebPath('css_SpryMenuBarHorizontal'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo Path::get()->getWebPath('css_jQuery_ui'); ?>" rel="stylesheet" type="text/css" />
{stylesheets,begin}
<link href="{*value}" rel="stylesheet" type="text/css" />
{stylesheets,end}
<script src="<?php echo Path::get()->getWebPath('js_SpryMenuBar'); ?>" type="text/javascript"></script>
<script src="<?php echo Path::get()->getWebPath('js_jQuery'); ?>" type="text/javascript"></script>
<script src="<?php echo Path::get()->getWebPath('js_jQuery_ui'); ?>" type="text/javascript"></script>
<script src="<?php echo Path::get()->getWebPath('js_jQuery_ui_tap'); ?>" type="text/javascript"></script>
{javascript,begin}
<script src="{*value}" type="text/javascript" /></script>
{javascript,end}
</head>

<body class="oneColElsCtrHdr">

<div id="container">
  <div id="header">
<img src="<?php echo Path::get()->getWebPath('gif_man'); ?>" alt="logo" width="142" height="142" align="left" />
<h1><img src="<?php echo Path::get()->getWebPath('gif_header'); ?>" width="682" height="91" alt="ts_header" /></h1>&nbsp;
    <ul id="MenuBar1" class="MenuBarHorizontal">
      <li><a href="<?php echo $prefix; ?>index.php">Home</a>      </li>
      <li><a href="#" class="MenuBarItemSubmenu">Manuals</a>
        <ul>
          <li><a href="<?php echo $prefix; ?>manual/poster.php">Poster</a></li>
          <li><a href="<?php echo $prefix; ?>manual/tutorial.php">Tutorial</a></li>
        </ul>
      </li>
      <li><a href="<?php echo $prefix; ?>datapack/datapack.php">Datapacks</a></li>
      <li><a href="<?php echo $prefix; ?>download/download.php">Download</a></li>
      <li><a href="<?php echo $prefix; ?>faq/faq.php">FAQs</a></li>
      <li><a href="<?php echo $prefix; ?>contactus/contactus.php">Contact Us</a></li>
	  <li><a href="<?php echo Path::get()->getWebPath('page_index'); ?>">TSC Lite</a></li>
      <li><a href="#" target="_blank" class="MenuBarItemSubmenu">TSC Pro</a>
        <ul>
          <li><a href="<?php echo $prefix; ?>tscpro/aboutpro.php">about TSC Pro</a></li>
          	<li><a href="<?php echo $prefix; ?>tscpro/login.php">Login</a></li>
        </ul>
      </li>
      <li><a href="<?php echo $prefix; ?>sponsor/sponsor.php">Sponsors</a></li>
	  <li><a href="<?php echo $prefix; ?>tscpro/login.php">Login</a></li>
</ul>
    <p>&nbsp;</p>
  <!-- end #header --></div>
