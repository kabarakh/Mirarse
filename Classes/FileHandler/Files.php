<?php
/*
 * Copyright notice
 *
 * (c) 2012/2013 Christian Herberger <webmaster@kabarakh.de>
 *
 * All rights reserved
 *
 * This script is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 */

namespace Kaba\Gallery\FileHandler;

/**
 * Everything which has to do with file handling
 */
class Files extends \Kaba\Gallery\ClassMagic\GalleryBaseClass {

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