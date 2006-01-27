<?php
/*
	The image handler class.
*/

class Image extends Folders {

	public $activeImage;	// full path of image
	public $imageSize;	// img filesize
	public $imageWidth;	// img width
	public $imageHeight;	// img height
	public $imageAttributes;// for use in the img tag
	public $imageType;	// the type of image
	public $imageFilename;	// just the file
	public $imageThumb;	// thumbnail hash (for thumb and resize)

	function __construct($start, $LocalPath, $extra) {
		// Construct!
		parent::__construct($start, $LocalPath);
		if ($start == "")
			$start = "/";
		$this->activeImage = $LocalPath . $start . $extra;
		$this->imageFilename = basename($this->activeImage);
		if ($start == "/") $start = "_/";
		$this->imageUrl = $start . $extra;
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

			$this->imageSize = filesize($this->activeImage);
		}
	}

	function createThumb() {
		// create the thumbnail
	}

	function createResize() {
		// create a smaller resized image, if required.
	}

	function checkThumb() {
		// if thumb doesn't exist generate it
		// check dates file vs. thumb
		// if file is newer, update thumb.
	}

	function checkResize() {
		// if resize is required
		// if resize is out of date
	}

	public function getImageHTML() {
		global $ighImage;

		$img = "<img src=\"". $ighImage . $this->imageUrl . "\" ".$this->imageAttributes."
			alt=\"".$this->imageFilename."\"/>";
		return $img;
	}

	public function getNextImageHTML() {
		return $img;
	}

	public function getPrevImageHTML() {
		return $img;
	}
}
?>
