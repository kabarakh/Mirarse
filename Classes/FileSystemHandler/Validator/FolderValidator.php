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

namespace Kaba\Gallery\FileSystemHandler\Validator;

/**
 * Everything which has to do with folder handling
 */
class FolderValidator extends \Kaba\Gallery\ClassMagic\GalleryBaseClass {

	/**
	 * @var \Kaba\Gallery\FileSystemHandler\Validator\FileValidator
	 * @inject
	 */
	protected $fileValidator;

	/**
	 * @var \Kaba\Gallery\FileSystemHandler\Validator\FolderContentValidator
	 * @inject
	 */
	protected $folderContentValidator;

	/**
	 * Returns true if a folder exists, false if otherwise
	 *
	 * @param $path
	 * @return bool
	 */
	public function validateFolderExists($path) {

		if ($path == FALSE) {
			return FALSE;
		}

		return TRUE;
	}

	/**
	 * Returns true if at least one image file exists in the folder, false if otherwise
	 *
	 * @param $path
	 * @return bool
	 */
	public function validateAtLeastOnePictureFileExists($path) {

		$contentsOfFolder = new \Kaba\Gallery\FileSystemHandler\FolderContentHandler($path);

		foreach ($contentsOfFolder->getContent() as $file) {
			if ($this->fileValidator->validateFileIsImage($path.'/'.$file)) {
				return TRUE;
			}
		}

		return FALSE;
	}

	/**
	 * returns true if at least one file exists in the folder, false if otherwise
	 *
	 * @param $path
	 *
	 * @return bool
	 */
	public function validateFolderHasAtLeastOneFile($path) {
		$folderContent = new \Kaba\Gallery\FileSystemHandler\FolderContentHandler($path);
		return $this->folderContentValidator->validateFolderContentContainsAtLeastOneFile($folderContent);
	}

}

?>