<?php

namespace Kaba\Gallery\FileHandler;

/**
 * Everything which has to do with file handling
 */
class Files {

	/**
	 * Checks if a file with the provided path is an imagefile. Uses finfo and the mimetype to check the files.
	 * If the mimetype starts with "image/", the file is an image and the function returns true, else returns false
	 *
	 * @param $pathToFile
	 *
	 * @return bool
	 */public function validateFileIsImage($pathToFile) {
		if (!$this->validateFileExists($pathToFile)) {
			return FALSE;
		}

		$finfo = new \finfo();

		$mimeType = $finfo->file($pathToFile, FILEINFO_MIME_TYPE);

		echo 'MimeType: '.$mimeType."\n";

		if (strncmp($mimeType, 'image/', 6) === 0) {
			return TRUE;
		}
		return FALSE;
}

	/**
	 * Returns true if a file exists, false if not
	 *
	 * @param $pathToFile
	 * @return bool
	 */public function validateFileExists($pathToFile) {
		if (is_file($pathToFile)) {
			return TRUE;
		}
		return FALSE;
	}
}

?>