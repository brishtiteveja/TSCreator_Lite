<? include_once($header_type); ?>

<!-- START CONTENT -->
<tr>
  <td align="center">
    Cannot generate Image, server timeout
  </td>

</tr>

<tr>
  <td align="center">
    <form action=<?=$_SERVER["PHP_SELF"]; ?> method="GET">
      <input type="submit" name="back" value="BACK">
    </form>
  </td>
</tr>

<? include_once($path->getFilePath("template_footer"));?>

