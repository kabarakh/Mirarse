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

namespace Kabarakh\Mirarse\FileSystemHandler\Validator;

/**
 * Everything which has to do with folder handling
 */
class FolderValidator extends \Kabarakh\Mirarse\ClassMagic\GalleryBaseClass implements \Kabarakh\Mirarse\ClassMagic\SingletonInterface {

	/**
	 * @var \Kabarakh\Mirarse\FileSystemHandler\Validator\FileValidator
	 * @inject
	 */
	protected $fileValidator;

	/**
	 * @var \Kabarakh\Mirarse\FileSystemHandler\Validator\FolderContentValidator
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

		if (is_dir($path) == FALSE) {
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

		$contentsOfFolder = new \Kabarakh\Mirarse\FileSystemHandler\FolderContentHandler($path);

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
		$folderContent = new \Kabarakh\Mirarse\FileSystemHandler\FolderContentHandler($path);
		return $this->folderContentValidator->validateFolderContentContainsAtLeastOneFile($folderContent);
	}

}

?>