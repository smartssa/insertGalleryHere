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
		global $ighLanding;
		$fl = "<ul>";
		foreach ($this->folders as $key => $folder) {
			$fl .= "<li><a href=\"". $ighLanding ."browse/". $folder . "/\">" . $folder. "</a></li>";
		}
		// fill up the unordered list.
		$fl .= "</ul>";
		return $fl;
	}

	function getThumbs() {
		return $this->thumbs;
	}

	function listThumbs() {
		global $ighLanding, $ighThumbHeight, $ighThumbWidth;
		$fl = "<ul>";
		// filler up with thumbs
		foreach ($this->thumbs as $key => $thumb) {
			$fl .= "<li><a href=\"" . $ighLanding . "view/" . $thumb . "\"><img src=\"" 
				. $ighLanding . "image/" . $thumb 
				. "/\" height=\"" . $ighThumbHeight . "\" width=\"" 
				. $ighThumbWidth . "\" alt=\"".$thumb."\"/></a></li>";
		}
		$fl .= "</ul>";
		return $fl;
	}	
}
?>
