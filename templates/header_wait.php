<html>
  <meta http-equiv="refresh" content="<?=$refresh_rate?>" >
  <title>TSCreator Lite</title>
  <body>
    <meta> 
    <table width="800" border="1" align="center">
    
      <!-- START HEADER -->
      <tr>
        <td>
          <img src="<?=$path->getWebPath("header_png")?>" alt="header" width="100%" />

        </td>
      </tr>

  <? if ($debug = 1){   ?>
      <tr>
        <td>
          Waiting for <?=$_SESSION["generate_pdf"] . "." . $_SESSION["chart_format"] . "</br>" ?>
        </td>
      </tr>
  <? } ?> 
      <!-- END HEADER -->

