<?php
/*
	class-folder.php
	gather up a listing of the current folder
	spew out an unordered list of sub folders
	spew out an unordered list of thumbnails for
	images within the current folder.
*/

class Folders {
	// declaring variables
	public $start = "";
	public $activeFolder = "";
	public $folders = array();
	public $thumbs = array();
	public $ignoreFiles = array('.', '..', '.svn');

	function __construct($start, $root) {
		$this->activeFolder = $root . $start;
		$this->start = $start;
		if ($start)
			$this->activeFolder = $this->activeFolder . "/";
		$this->scanFolder();
	}

	function __destruct() {
		// DIE CLASS DIE!
	}

	function scanFolder() {
		// build a list of folders/thumbs
		$dir = $this->activeFolder;
		if (is_dir($dir)) {
			if ($dir_handle = opendir($dir)) {
				while ($file = readdir($dir_handle)) {
					if (is_dir($this->activeFolder . $file)
						&& !in_array($file, $this->ignoreFiles)) {
						$this->folders[] = $file;
					} elseif (strstr(mime_content_type($this->activeFolder . $file), "image") &&
						filetype($this->activeFolder . $file) == "file") {
						$this->thumbs[] = $file;
					}
				}
				closedir($dir_handle);
			}
		}
	}

	function getFolders() {
		return $this->folders;
	}

	function listFolders() {
		global $ighBrowse;
		$fl = "<ul>";
		foreach ($this->folders as $key => $folder) {
			$fl .= "<li><a href=\"". $ighBrowse . $folder . "/\">" . $folder. "</a></li>";
		}
		// fill up the unordered list.
		$fl .= "</ul>";
		return $fl;
	}

	function getThumbs() {
		return $this->thumbs;
	}

	function listThumbs() {
		global $ighThumb, $ighView, $ighThumbHeight, $ighThumbWidth;
		if ($this->start == "") {
			// this underscore signifies the 'root'
			$folder = "_/";
		} else {
			$folder = $this->start."/";
		}
		$fl = "<ul>";
		// filler up with thumbs
		foreach ($this->thumbs as $key => $thumb) {
			$fl .= "<li><a href=\"" . $ighView . $folder . $thumb . "\">
				<img src=\"" . $ighThumb . $folder . $thumb 
				. "\" height=\"" . $ighThumbHeight . "\" width=\"" 
				. $ighThumbWidth . "\" alt=\"".$thumb."\"/></a></li>";
		}
		$fl .= "</ul>";
		return $fl;
	}	
}
?>
