<?
  $size            = $_SESSION["im_size"];
  $hand = fopen("hello.txt",'w');
  fwrite("$size\n");
  $image_type      = $_SESSION["im_image_type"];
  $filepath        = $_SESSION["im_filepath"];
  $datapack_parsed = $_SESSION["datapack_parsed"];

	if($datapack_parsed["datapack_coord"]["coord"] == "vertical") {
		print_r($datapack_parsed);
		die();
		$xfactor = $yfactor = (0.4*$size[0])/$datapack["parsed_coord"]["scale"];
	} else {
  	$xfactor = $size[0] / $datapack_parsed["datapack_coord"]["lower_right_lon"];
  	$yfactor = $size[1] / $datapack_parsed["datapack_coord"]["lower_right_lat"];
	}
   
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
  $black_ellipse = imagecolorallocate($img,1,1,1);

  foreach($datapack_parsed["datapack_col"] as $datapoint){
		if($datapack_parsed["datapack_coord"]["coord"] == "vertical") {
			lonOffset = $datapoint["lon"] - $datapack_parsed["datapack_cord"]["center"]
		} else {
			$x = $datapoint["lon"] * $xfactor;
			$y = $datapoint["lat"] * $yfactor;
		}

    if ($datapoint["bool"] == "true") imagefilledellipse($img, $x, $y, 50, 50, $green_ellipse);
    else                              imagefilledellipse($img, $x, $y, 50, 50, $red_ellipse);

    imageellipse($img, $x, $y, 50, 50, $black_ellipse);
  }
  header('Content-type: image/png');
  imagepng($img);
  imagedestroy($img);

?>
