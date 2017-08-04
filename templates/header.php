<?php

if (!isset($prefix))
	$prefix = "./"; //$prefix = "../";
?>
<link href="<?php echo $prefix; ?>../global/CSS/oneColElsCtrHdr.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $prefix; ?>../global/SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="<?php echo $prefix; ?>../global/SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $prefix; ?>../global/images/favicon.ico" rel="shortcut icon" />
</head>

<body class="oneColElsCtrHdr">

<div id="container">
  <div id="header">
<img src="<?php echo $prefix; ?>../global/images/5man.gif" alt="logo" width="142" height="142" align="left" />
<h1><img src="<?php echo $prefix; ?>../global/images/TSCreator_Header.gif" width="682" height="91" alt="ts_header" /></h1>&nbsp;
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
	  <li><a href="<?php echo $prefix; ?>newsletter/newsletter.php">News Letter</a></li>
      <li><a href="#" target="_blank" class="MenuBarItemSubmenu">TSC Pro</a>
        <ul>
          <li><a href="<?php echo $prefix; ?>tscpro/aboutpro.php">about TSC Pro</a></li>
          <?php
//          	if (isLoggedIn()){
//         		print("<li><a href=\"${prefix}tscpro/prodownload.php\">TSC Pro Downloads</a></li>");
//          		print("<li><a href=\"${prefix}tscpro/logout.php\">Logout</a></li>");
//          	} else {
          		print("<li><a href=\"${prefix}tscpro/login.php\">Login</a></li>");
//          	}
          ?>
        </ul>
      </li>
      <li><a href="<?php echo $prefix; ?>sponsor/sponsor.php">Sponsors</a>      </li>
	  <?php
//		if (isLoggedIn()){
//			print("<li><a href=\"${prefix}tscpro/logout.php\">Logout</a></li>");
//		} else {
			print("<li><a href=\"${prefix}tscpro/login.php\">Login</a></li>");
//		}
	  ?>

</ul>
    <p>&nbsp;</p>
  <!-- end #header --></div>
