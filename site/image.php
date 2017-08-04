<?
  session_start();

  $image_type      = $_SESSION["im_image_type"];
  $filepath        = $_SESSION["im_filepath"];
  $datapack_parsed = $_SESSION["datapack_parsed"];
  $start_age_val   = $_SESSION["start_age_val"];
  $end_age_val     = $_SESSION["end_age_val"];
  $xlength         = $_SESSION["xlength"];
  $ylength         = $_SESSION["ylength"];
  $xfactor         = $_SESSION["xfactor"];
  $yfactor         = $_SESSION["yfactor"];
  
  switch($image_type){
    case "png":
      $img = imagecreatefrompng($filepath);
      break;

    case "jpeg":
      $img = imagecreatefromjpeg($filepath);
      break;

    case "gif":
      $img = imagecreatefromgif($filepath);
      break;
    
    default:
      break;
  }

  imageinterlace($img,true);

  $green_ellipse = imagecolorallocate($img,1,255,1);
  $red_ellipse   = imagecolorallocate($img,255,1,1);
  $grey_ellipse = imagecolorallocate($img,195,195,195);

  $new_img = imagecreatetruecolor($xlength,$ylength);
  $white = imagecolorallocate($new_img,255,255,255);

  imagefill($new_img, 0 , 0, $white);
  imagecopyresized($new_img, $img, 0,  0, 0, 0, $xlength, $ylength, imagesx($img), imagesy($img));

  foreach($datapack_parsed["datapack_col"] as $datapoint){
    $x = $datapoint["lon"] * $xfactor;
    $y = $datapoint["lat"] * $yfactor;

  
  // if datacol is outside of top and base age, make datacol unselectable
    if (($start_age_val > $datapoint["max_age"] or $end_age_val < $datapoint["min_age"]) and (isset($datapoint["min_age"]) and isset($datapoint["max_age"])) ){
      imagefilledellipse($new_img, $x, $y, 20, 20, $grey_ellipse);
      $datapoint["bool"] = "false";
    }
    else if ($datapoint["bool"] == "true")   
      imagefilledellipse($new_img, $x, $y, 20, 20, $green_ellipse);
    else                                                                                
      imagefilledellipse($new_img, $x, $y, 20, 20, $red_ellipse);

    imageellipse($new_img, $x, $y, 20, 20, $black_ellipse);
  }

  header('Content-type: image/' . $img_type);
  imagepng($new_img);
  imagedestroy($new_img);
?>
