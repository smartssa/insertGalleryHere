<?php
/*
	class-folder.php
	gather up a listing of the current folder
	spew out an ordered list of sub folders
	spew out an ordered list of thumbnails for
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
			sort($this->folders);
			sort($this->thumbs);
		}
	}

	public function getFolders() {
		return $this->folders;
	}

	public function listFolders() {
		global $ighBrowse;
		$fl = "<ul>";
		foreach ($this->folders as $key => $folder) {
			$fl .= "<li><a href=\"". $ighBrowse . $this->start . 
				$folder . "/\">" . $folder. "</a></li>";
		}
		// fill up the unordered list.
		$fl .= "</ul>";
		return $fl;
	}

	public function getThumbs() {
		return $this->thumbs;
	}

	public function listThumbs() {
		global $ighThumb, $ighView, $ighThumbHeight, $ighThumbWidth;
		if ($this->start == "") {
			// this underscore signifies the 'root'
			$folder = "_/";
		} else {
			$folder = $this->start;
		}
		$fl = "<ul>";
		// filler up with thumbs
		foreach ($this->thumbs as $key => $thumb) {
			$fl .= "<li><a href=\"" . $ighView . $folder . $thumb . "\">
				<img src=\"" . $ighThumb . $folder . $thumb 
				. "\" alt=\"".$thumb."\"/></a></li>";
		}
		$fl .= "</ul>";
		return $fl;
	}

	public function listCrumbs() {
		global $ighBrowse;
		// return an ul of the crumb fun
		$cr = "<ul>";
		$cr .= "<li><a href=\"" . $ighBrowse . "\">Start</a></li>";
		$folder = explode("/",$this->start);
		$previous = "";
		foreach ($folder as $key=>$data) {
			if ($data != "") {
			$cr .= "<li><a href=\"". $ighBrowse .$previous. $data . "/\">" . $data . "</a></li>";
			$previous .= $data ."/";
			}
		}
		$cr .= "</ul>";
		return $cr;
	}
}
?>
