<? include_once($header_type); ?>

<!-- START CONTENT -->
<tr>
  <td align="center">
    <form action=<?=$_SERVER["PHP_SELF"]; ?> method="GET">
      <input type="submit" name="back" value="BACK">
    </form>
  </td>
</tr>

<tr>
  <td align="center">
    <img src="<?= $path->getWebPath("Output") . $_SESSION["generate_pdf"] .".". $_SESSION["chart_format"] ?>"/>
  </td>

</tr>

<? include_once($path->getFilePath("template_footer"));?>

