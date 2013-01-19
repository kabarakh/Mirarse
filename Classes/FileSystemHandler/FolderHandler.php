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

namespace Kabarakh\Mirarse\FileSystemHandler;

/**
 * Everything which has to do with folder handling
 */
class FolderHandler extends \Kabarakh\Mirarse\ClassMagic\GalleryBaseClass {

	/**
	 * @var \Kabarakh\Mirarse\FileSystemHandler\Validator\FolderValidator
	 * @inject 
	 */
	protected $folderValidator;

	/**
	 * @var \Kabarakh\Mirarse\FileSystemHandler\FileHandler
	 * @inject
	 */
	protected $fileHandler;

	/**
	 * returns an array with all folders and files in the respective $path
	 * if relative is true, $path is considered inside of MIRARSE_RUN_DIRECTORY
	 *
	 * @param $path
	 * @param bool $relative
	 *
	 * @return \Kabarakh\Mirarse\FileSystemHandler\FolderContentHandler|null
	 * @throws \Exception
	 */
	public function getContentsOfFolder($path, $relative = FALSE) {

		if ($relative) {
			$path = $this->getAbsolutePathFromRelativePath($path);
		} else {
			$path = realpath($path);
		}

		if (empty($path)) {
			throw new \Exception('GalleryRootPath could not be resolved', 1357860838);
		}

		if (!$this->folderValidator->validateFolderHasAtLeastOneFile($path)) {
			return NULL;
		}

		$folderContent = new \Kabarakh\Mirarse\FileSystemHandler\FolderContentHandler($path);

		$folderContent->removeDotDirectoriesFromFolderContent();

		$temporaryArray = array();

		foreach ($folderContent->getContent() as $filename) {
			$temporaryArray[] = $path . '/' . $filename;
		}

		$folderContent->setContent($temporaryArray);

		return ($folderContent);
	}

	/**
	 * Makes a path relative to the file which runs the script absolute
	 *
	 * @param $relativePath
	 *
	 * @return string
	 * @throws \Exception
	 */
	protected function getAbsolutePathFromRelativePath($relativePath) {
		$absolutePath = realpath(MIRARSE_RUN_DIRECTORY . $relativePath);

		if (!$this->folderValidator->validateFolderExists($absolutePath)) {
			throw new \Exception('Path ' . $relativePath . ' not accessible or does not exist', 1357353323);
		}

		return $absolutePath;
	}

	/**
	 * get the config file from a gallery folder
	 *
	 * @param $path
	 *
	 * @return array
	 * @throws \Exception
	 */
	public function getConfigFileFromFolder($path) {
		$pathOfConfigFile = $this->getFullPathToConfigFile($path);
		return $this->fileHandler->getConfigArrayFromYamlFile($pathOfConfigFile);
	}

	/**
	 * Generates the path to a gallery config file. Respects the config file name setting
	 *
	 * @param $path
	 *
	 * @return string
	 */
	public function getFullPathToConfigFile($path) {
		$configFileName = 'gallery.yml';

		if ($GLOBALS['parameter']['galleryConfigFile']) {
			$configFileName = $GLOBALS['parameter']['galleryConfigFile'];
		}

		return $path . '/' . $configFileName;
	}

}

?>