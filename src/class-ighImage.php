<?php
/*
	The image handler class.
*/

require_once "class-ighFolder.php";

class Image extends Folders {

	public $activeImage;	// full path of image
	public $imageSize;	// img filesize
	public $imageWidth;	// img width
	public $imageHeight;	// img height
	public $imageAttributes;// for use in the img tag
	public $imageType;	// the type of image
	public $imageFilename;	// just the file
	public $imageThumb;	// thumbnail hash (for thumb and resize)
	public $imageStart;	// start path

	function __construct($LocalPath, $fullfilepath, $params) {
		// Construct!

		$full = urldecode($start . (dirname($fullfilepath) == "." ? "" : dirname($fullfilepath)."/"));
		parent::__construct($full, $LocalPath, $params);

		$this->imageStart = $full;
		$this->activeImage = $LocalPath . $fullfilepath;

		$this->imageFilename = basename($this->activeImage);
		$this->imageUrl = $start . $fullfilepath;
		$this->imageThumb = md5($this->activeImage); // all thumbnails will be jpeg
		$this->loadDetails();
		$this->checkThumb();
		$this->checkResize();
	}

	function __deconstruct() {
		// DIE!
	}

	function loadDetails() {
		// get the file details
		if (file_exists($this->activeImage)) {
			list ($this->imageWidth, $this->imageHeight, $this->imageType, $this->imageAttributes) =
				getimagesize($this->activeImage);
			$this->imageType = image_type_to_mime_type($this->imageType);
			$this->imageSize = filesize($this->activeImage);
		}
	}

	function createThumb() {
		global $ighCacheThumbs, $ighThumbHeight, $ighThumbWidth;
		// create the thumbnail
		imageResize($this->activeImage, $ighCacheThumbs.$this->imageThumb, $ighThumbHeight, $ighThumbWidth, TRUE);
	}

	function createResize() {
		global $ighCacheResize, $ighMaxWidth, $ighMaxHeight;
		// create a smaller resized image, if required.
		imageResize($this->activeImage, $ighCacheResize.$this->imageThumb, $ighMaxHeight, $ighMaxWidth, FALSE);
	}

	function checkThumb() {
		global $ighCacheThumbs;
		// if thumb doesn't exist generate it
		if (file_exists($ighCacheThumbs . $this->imageThumb) ) {
			// We have a thumb
			// check dates file vs. thumb
			// if file is newer, update thumb.
			if (filectime($this->activeImage) > filectime($ighCacheThumbs . $this->imageThumb))
				$this->createThumb();
		} else {
			// No Thumb
			$this->createThumb();
		}
		// Nothing happens if it's ok.
	}

	function checkResize() {
		global $ighCacheResize, $ighMaxWidth, $ighMaxHeight;
		// if resize is required
		if (file_exists($ighCacheResize . $this->imageThumb) ) {
			// if resize is out of date
			if (filectime($this->activeImage) > filectime($ighCacheResize . $this->imageThumb))
				$this->createResize();
		} elseif (!file_exists($ighCacheResize . $this->imageThumb) ) {
			if ($this->imageHeight > $ighMaxHeight || $this->imageWidth > $ighMaxWidth)
				$this->createResize();
		}
	}

	public function getImageHTML() {
		global $ighImage;

		$img = "<img src=\"". $ighImage . $this->params . "/" . $this->imageUrl . "\" 
			alt=\"".$this->imageFilename."\"/>";
		return $img;
	}

	public function getNextImageHTML() {
		global $ighView, $ighThumb;
		$key = array_search($this->imageFilename, $this->thumbs);
		if (array_key_exists($key+1, $this->thumbs)) {
			$img = "<a href=\"" . $ighView . $this->params . "/" . $this->imageStart . $this->thumbs[$key+1] . "\">";
			$img .= "<img src=\"" .$ighThumb . $this->params . "/" . $this->imageStart . $this->thumbs[$key+1] . "\"
				alt=\"".$this->thumbs[$key+1]."\"/>";
			$img .= "</a>"; 
		}
		return $img;
	}

	public function getPrevImageHTML() {
		global $ighView, $ighThumb;
		$key = array_search($this->imageFilename, $this->thumbs);
		if (array_key_exists($key-1, $this->thumbs)) {
			$img = "<a href=\"" . $ighView . $this->params . "/" . $this->imageStart . $this->thumbs[$key-1] . "\">";
			$img .= "<img src=\"" .$ighThumb . $this->params . "/" . $this->imageStart . $this->thumbs[$key-1] . "\"
				alt=\"".$this->thumbs[$key-1]."\"/>";
			$img .= "</a>";
		}
		return $img;
	}
}
?>
