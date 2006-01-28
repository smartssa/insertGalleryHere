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
	$thumb bool - whether or not to prettyify the resize
*/

function imageResize($file, $dest, $height, $width, $thumb = FALSE) {
	global $ighMaxHeight, $ighMaxWidth;

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

        $thumb_height = 120;
        $thumb_width = 120;

        // Work out which way it needs to be resized
        $img_width_per = $thumb_width / $img_width;
        $img_height_per = $thumb_height / $img_height;

    
        if ($img_width_per <= $img_height_per) {
            $thumb_height = intval($img_height * $img_width_per);   
        }
        else {
            $thumb_width = intval($img_width * $img_height_per);
        }
        // Create the new thumbnail image
        $thumb_img = ImageCreateTrueColor($thumb_width, $thumb_height); 

        ImageCopyResampled($thumb_img, $base_img, 0, 0, 0, 0, $thumb_width, $thumb_height, $img_width, $img_height);

	imagepng($thumb_img, $dest);
	imagedestroy($base_img);
	imagedestroy($thumb_img);
}

function dateCompare($dateModified, $dateToCompare) {
	// compare dates in format: Fri, 27 Jan 2006 05:21:35 GMT 
	
	// these dates are expected in unixtimestamp
	if ($dateModified > $dateToCompare)
		return true;
	else
		return false;
}
?>
