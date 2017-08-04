<? include_once($path->getFilePath("template_header_wait")); ?>

<!-- START CONTENT -->
<tr>
  <td>
    <!-- --> 
      <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
          <!-- datapack, tutorial labels -->
          <td width="30%" align="left">
            <table width="100%" cellspacing="0" cellpadding="0" border="0">
              <tr>
                <td width="100%" align="center">
                  <a href="<?=$path->getWebPath("page_datapack_help")?>" target="_blank">Datapack</a>
                </td> 
              </tr>
               
              <tr>
                <td width="100%" align="center">
                  <a href="<?= $path->getWebPath("page_tutorial")?>" target="_blank">Tutorial</a>
                </td>
              </tr>
            </table>  
          </td>
          
          <form action=<?=$_SERVER["PHP_SELF"]; ?> method="GET">
            <!-- dropdownbar -->
            <td width="40%" align="left">
              <select name="datapack">
                <? foreach ($datapack_choices as $datapack_choice){ ?>
                <option value="<?= $datapack_choice["value"] ?>" 
                  <?if($datapack_choice["value"] == $cur_datapack) { echo " SELECTED ";}
                  ?>>
                  <?= $datapack_choice["text"] ?></option>
                <?  }?>
              </select>  
            
            </td>
            <!-- RESET and LOAD -->
         
            <td width="30%" align="left">
              <table width="100%" cellspacing="0" cellpadding="0" border="0">
              <!---->
                <tr>
                  <td width="100%" align="left">
                    <input type="reset" name="reset" value="RESET">
                  </td>
                </tr>
                <tr>
                  <td width="100%" align="left"> 
                    <input type="submit" name="load" value="LOAD">
  <!--                  <input type="hidden" name="datapack" value="<?=$cur_datapack?>" /> -->
                    <input type="hidden" name="view" value="<?=$view?>" />
                  </td> 
                </tr>
              <!---->
              </table>
            </td>     
          </tr>
        </table>
      </form>
    <!-- ** --> 
    <tr>
      <td>
        <table width="100%" cellspacing="0" cellpadding="0" border="0">
          <tr>

            <td>            
              <table width="100%" cellspacing="0" cellpadding="0" border="0">        
                <tr>
                  <td width="100%" align="center">
                    <a href="<?= $path->getWebPath("page_time_interval_help")?>" target="_blank">Time Interval</a>
                  </td>

                </tr>
            
                <tr>
                  <td width="100%" align="center">
                    <a href="<?= $path->getWebPath("page_tscreator_lite_help")?>" target="_blank">TSCreator Lite Help</a>
                  </td>
                </tr>
              </table>
            </td>

            <td>
              <table width="100%" cellspacing="0" cellpadding="0" border="0">
                <form name="input" action="<?= $_SERVER["PHP_SELF"] ?>" method="post" >   
                  <tr>
                    <td width="100%" align="left">
                      <input type="text" name="start_age_val" value="<?= $start_age_val ?>" />
                      <a href="<?= $path->getWebPath("page_start_age_help")?>" target="_blank">START AGE</a><br />
                    </td>
                  </tr>

                  <tr>
                    <td width="100%" align="left">
                      <input type="text" name="end_age_val" value="<?= $end_age_val ?>" />
                      <a href="<?= $path->getWebPath("page_end_age")?>" target="_blank">END AGE</a><br />
                    </td>
                  </tr>

                  <tr>
                    <td width="100%" align="left">
                      <input type="text" name="vertical_scale_val" value="<?= $vertical_scale_val ?>" />
                      <a href="<?= $path->getWebPath("page_vertical_scale")?>" target="_blank">VERTICAL SCALE</a><br />
                    </td>
                  </tr>
            
                  <tr>
                    <td width="100%" align="left">
                      <input type="submit" name="sub"      value="SET TIME" />
                    </td>
                  <tr>
                </form>  
              </table>
            </td>
          </tr>
        </table>        
      </td>
    </tr>
    
    <!--  -->
    <tr>
      <td>
        <table width="100%" cellspacing="0" cellpadding="0" border="0">
          <form action=<?=$_SERVER["PHP_SELF"]; ?> method="post">
            <tr>
              <td width="100%" align="center">
                <input type="submit" name="sub"      value="GENERATE" />
              </td>
            </tr>
          </form>
        
          <!-- MAP AREA -->
          <tr>
            <td width="100%" align="center">
           <? if (isset($datapack_parsed)){ 
                $size       = getimagesize($path->getFilePath("Datapacks") . $datapack_choices[$cur_datapack]["img"]);
                $image_type = $datapack_choices[$cur_datapack]["img_type"];
                $filepath   = $path->getFilePath("Datapacks") . $datapack_choices[$cur_datapack]["img"];
                $xfactor    = $size[0] / $datapack_parsed["datapack_coord"]["lower_right_lat"];
                $yfactor    = $size[1] / $datapack_parsed["datapack_coord"]["lower_right_lon"];
                $contents   = $mapgen->generate($datapack_parsed,$size,$image_type,$xfactor,$yfactor,$filepath);
           ?>
              
              <img src="<? echo "data:image/png;base64," .base64_encode($contents) ?>" align="center" usemap="#columns" />
              <map name="columns">
              <?
                foreach($datapack_parsed["datapack_col"] as $i=>$datapoint){
                  $x = $datapoint["lon"] * $xfactor;
                  $y = $datapoint["lat"] * $yfactor;
              ?>
                <area shape="circle" coords="<?=$x ?>,<?=$y ?>,25" href="<?=$_SERVER["PHP_SELF"]?>?view=<?=$view?>&datacolid=<?=$i?>" title="<?=$datapoint["name"] ?>" />
                  
              <?
                }  
              ?> 
              </map>
          <?}else {?>
              <img src="<?=$path->getWebPath("basedir_images") . $datapack_choices[$cur_datapack]["img"] ?>" align="center" />
         <? } ?>
              

            </td>
          </tr>
        </table>
      </td>
    </tr>
 
    <!-- NOTE AREA -->
    <tr>
      <td>
        <table width="100%" cellspacing="0" cellpadding="0" border="0">
          <?
            if (isset($datapack_parsed)){?>
              <tr>
                <td> 
          <?= "Map Name : " . $datapack_parsed["datapack_info"]["map_name"] . "</br>" .
              $datapack_parsed["datapack_info"]["note"] . "</br></br>";

              foreach($datapack_parsed["datapack_col"] as $choice) {
                echo $choice["name"] . "  <i> " . $choice["note"] . "</i></br>";
              }
          ?>
          

                </td>
              </tr>
          <?    
            }

          ?>
        </table>
      </td>
    </tr>    

  </td>
</tr>

<? include_once($path->getFilePath("template_footer"));?>

