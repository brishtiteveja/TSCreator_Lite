<? include_once($header_type); ?>
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
                  <a href="<?=Path::get()->getWebPath("page_datapack_help")?>" target="_blank">Datapack</a>
                </td> 
              </tr>
               
              <tr>
                <td width="100%" align="center">
                  <a href="<?= Path::get()->getWebPath("page_tutorial")?>" target="_blank">Tutorial</a>
                </td>
              </tr>
            </table>  
          </td>
          
          <form action=<?=$_SERVER["PHP_SELF"]; ?> method="get">
            <!-- dropdownbar -->
            <td width="40%" align="left">
              <select name="datapack" onChange=submit()>
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
                    <input type="submit" name="reset" value="RESET">
                  </td>
                </tr>
                <tr>
                  <td width="100%" align="left"> 
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
                    <a href="<?= Path::get()->getWebPath("page_time_interval_help")?>" target="_blank">Time Interval</a>
                  </td>

                </tr>
            
                <tr>
                  <td width="100%" align="center">
                    <a href="<?= Path::get()->getWebPath("page_tscreator_lite_help")?>" target="_blank">TSCreator Lite Help</a>
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
                      <a href="<?= Path::get()->getWebPath("page_start_age_help")?>" target="_blank">START AGE</a><br />
                    </td>
                  </tr>

                  <tr>
                    <td width="100%" align="left">
                      <input type="text" name="end_age_val" value="<?= $end_age_val ?>" />
                      <a href="<?= Path::get()->getWebPath("page_end_age")?>" target="_blank">END AGE</a><br />
                    </td>
                  </tr>

                  <tr>
                    <td width="100%" align="left">
                      <input type="text" name="vertical_scale_val" value="<?= $vertical_scale_val ?>" />
                      <a href="<?= Path::get()->getWebPath("page_vertical_scale")?>" target="_blank">VERTICAL SCALE</a><br />
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
                <input type="radio" name="chart_format" value="png" <?= $png_status ?>> generate png chart<br>
                <input type="radio" name="chart_format" value="pdf" <?= $pdf_status ?>> generate pdf chart<br>
              </td>
            </tr>
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
                $size       = getimagesize(Path::get()->getFilePath("Datapacks") . $datapack_choices[$cur_datapack]["img"]);
                $image_type = $datapack_choices[$cur_datapack]["img_type"];
                $filepath   = Path::get()->getFilePath("Datapacks") . $datapack_choices[$cur_datapack]["img"];

                //if width is more than height, set X to 1000 and scale Y accordingly
                if ($size[0] > $size[1]) {
                  $xlength = $longest_side;
                  $ylength = $longest_side * $size[1] / $size[0];

                } else{
                  $ylength = $longest_side;
                  $xlength = $longest_side * $size[0] / $size[1];

                }

                // find scale factor for x,y coordinates
                $xfactor    = $xlength / $datapack_parsed["datapack_coord"]["lower_right_lon"];
                $yfactor    = $ylength / $datapack_parsed["datapack_coord"]["lower_right_lat"];
              
                $_SESSION["xlength"]        = $xlength;
                $_SESSION["ylength"]        = $ylength;
                $_SESSION["xfactor"]        = $xfactor;
                $_SESSION["yfactor"]        = $yfactor;
                $_SESSION["im_image_type"]   = $image_type;
                $_SESSION["im_filepath"]     = $filepath;
                $_SESSION["datapack_parsed"] = $datapack_parsed;


                ?>
              
              <img src="../image.php" align="center" usemap="#columns" />
              <map name="columns">
              <?
                foreach($datapack_parsed["datapack_col"] as $i=>$datapoint){
                  $x = $datapoint["lon"] * $xfactor;
                  $y = $datapoint["lat"] * $yfactor;
             
                  //if datacol is not within time age, make it unselectable
                  if(!($start_age_val > $datapoint["max_age"] or $end_age_val < $datapoint["min_age"]) or !(isset($datapoint["min_age"]) and isset($datapoint["max_age"])) ){
                  ?>                
                    <area shape="circle" coords="<?=$x ?>,<?=$y ?>,20" href="<?=$_SERVER["PHP_SELF"]?>?view=<?=$view?>&datacolid=<?=$i?>" title="<?=$datapoint["name"] ?>" />
                  <?
                  }
                  
                }  
              ?> 
              </map>
          <?}else {?>
              <img src="<?=Path::get()->getWebPath("basedir_images") . $datapack_choices[$cur_datapack]["img"] ?>" align="center" />
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

<? include_once(Path::get()->getFilePath("template_footer"));?>

