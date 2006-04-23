<?php
/*
	common functions of various sorts
*/

/*
	params:
	$file str - the original file (full path)
	$dest str - the destination file (full path)
	$height int - new height
	$width int - new width
	$thumb bool - whether or not to use the "square on centre" thumbnail feature.
*/

function imageResize($file, $dest, $height, $width, $thumb = FALSE) {
	global $ighMaxHeight, $ighMaxWidth, $ighThumbHeight, $ighThumbWidth;

	if (strstr(@mime_content_type($file), "png"))
		$oldImage = imagecreatefrompng($file);
	elseif (strstr(@mime_content_type($file), "jpeg"))
		$oldImage = imagecreatefromjpeg($file);
	elseif (strstr(@mime_content_type($file), "gif"))
		$oldImage = imagecreatefromgif($file);
	else
		die ("oh shit");

	$base_img = $oldImage;
        $img_width = imagesx($base_img);
        $img_height = imagesy($base_img);

        $thumb_height = $height;
        $thumb_width = $width;

        // Work out which way it needs to be resized
        $img_width_per = $thumb_width / $img_width;
        $img_height_per = $thumb_height / $img_height;
    
        if ($img_width_per <= $img_height_per) {
            $thumb_height = intval($img_height * $img_width_per);   
        }
        else {
            $thumb_width = intval($img_width * $img_height_per);
        }

	if ($thumb) {
		$thumb_width = $width;		// 120
		$thumb_height = $height*3/4;	// 120 * 3 / 4 = 90
	}

        // Create the new thumbnail image
        $thumb_img = ImageCreateTrueColor($thumb_width, $thumb_height); 

	if ($thumb) {	// Do the Square from the Centre thing.
		ImageCopyResampled($thumb_img, $base_img, 0, 0, 
				($img_width/2)-($thumb_width/2), ($img_height/2)-($thumb_height/2), 
				$thumb_width, $thumb_height, $thumb_width, $thumb_height);			
	} else {	// standard image to image resize.
		ImageCopyResampled($thumb_img, $base_img, 0, 0, 0, 0, 
				$thumb_width, $thumb_height, $img_width, $img_height);
	}

	// using jpegs!
	imagejpeg($thumb_img, $dest);
	imagedestroy($base_img);
	imagedestroy($thumb_img);
}

function dateCompare($dateToCompare, $dateModified) {
	// compare dates in format unixtime
	// these dates are expected in unixtimestamp
	if ($dateModified > $dateToCompare)
		return true;
	else
		return false;
}
?>
