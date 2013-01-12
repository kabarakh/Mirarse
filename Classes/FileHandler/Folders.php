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
 * Everything which has to do with folder handling
 */
class Folders extends \Kaba\Gallery\ClassMagic\GalleryBaseClass {


	/**
	 * returns an array with all folders and files in the respective $path
	 * if relative is true, $path is considered inside of GALLERY_RUN_DIRECTORY
	 *
	 * @param $path
	 * @param bool $relative
	 *
	 * @return array|null
	 * @throws \Exception
	 */public function getContentsOfFolder($path, $relative = FALSE) {

		echo "\n\nPath: ".$path."\n";
		echo 'Realpath: '.realpath($path)."\n\n";

		if ($relative) {
			$path = $this->getAbsolutePathFromRelativePath($path);
		} else {
			$path = realpath($path);
		}

		if (empty($path)) {
			throw new \Exception('GalleryRootPath could not be resolved', 1357860838);
		}

		if (!$this->validateFolderHasAtLeastOneFile($path)) {
			return NULL;
		}

		$folderContent = scandir($path);

		$folderContent = $this->removeDotDirectoriesFromFolderContent($folderContent);

		foreach ($folderContent as &$filename) {
			echo 'FileName: '.$path.'/'.$filename."\n";

			$filename = $path.'/'.$filename;
		}

		print_r($folderContent, FALSE);

		return ($folderContent);
}

	/**
	 * Makes a path relative to the file which runs the script absolute
	 *
	 * @param $relativePath
	 * @return string
	 * @throws \Exception
	 */
	protected function getAbsolutePathFromRelativePath($relativePath) {
		$absolutePath = realpath(GALLERY_RUN_DIRECTORY.$relativePath);

		if (!$this->validateFolderExists($absolutePath)) {
			throw new \Exception('Path '.$relativePath.' not accessible or doesn\'t exist', 1357353323);
		}

		echo 'AbsolutePath: '.$absolutePath."\n";

		return $absolutePath;
}

	/**
	 * Returns true if a folder exists, false if otherwise
	 *
	 * @param $path
	 * @return bool
	 */
	protected function validateFolderExists($path) {

		if ($path == FALSE) {
			return FALSE;
		}

		return TRUE;
}

	/**
	 * Removes "." and ".." from an folder content array
	 *
	 * Resets the array keys to start from 0 with array_slice
	 *
	 * @param $folderContent
	 * @return array
	 */
	protected function removeDotDirectoriesFromFolderContent($folderContent) {
		unset($folderContent[array_search('.', $folderContent)]);
		unset($folderContent[array_search('..', $folderContent)]);

		$folderContent = array_slice($folderContent, 0);

		return $folderContent;
}

	/**
	 * Filters a folder content array so that everything except folders is removed from the array
	 *
	 * Resets the array keys to start from 0 with array_slice
	 *
	 * @param $contentsOfRootPath
	 * @return mixed
	 */
	public function limitResultToFolders($contentsOfRootPath) {
		foreach ($contentsOfRootPath as $key => $filename) {
			if (!is_dir($filename)) {
				unset($contentsOfRootPath[$key]);
			}
		}

		print_r($contentsOfRootPath, FALSE);

		return $contentsOfRootPath;
	}

	/**
	 * Filters a folder content array so that everything except valid gallery folders is removed from the array
	 *
	 * A valid folder for the gallery consists of at least one picture and the config file (name gallery.conf, can be
	 * overridden while calling an action)
	 *
	 * @param $contentsOfRootPath
	 * @return array
	 */
	public function limitResultToValidFolders($contentsOfRootPath) {

		foreach ($contentsOfRootPath as $key => $foldername) {

			$configFileExists = $this->validateConfigFileExists($foldername);
			$onePictureExists = $this->validateAtLeastOnePictureFileExists($foldername);

			if (!$configFileExists || !$onePictureExists) {
				unset($contentsOfRootPath[$key]);
			}
		}

		$contentsOfRootPath = array_slice($contentsOfRootPath, 0);

		print_r($contentsOfRootPath);

		return $contentsOfRootPath;
	}

	/**
	 * Returns true if a config file exists in the folder, false if otherwise
	 * Uses the GLOBALS-parameter-array to get the name for the config-files
	 *
	 * @param $foldername
	 * @return bool
	 */
	protected function validateConfigFileExists($foldername) {
		$configFilePath = $this->getFullPathToConfigFile($foldername);

		$fileHandler = new \Kaba\Gallery\FileHandler\Files();

		return $fileHandler->validateFileExists($configFilePath);
	}

	/**
	 * Generates the path to a gallery config file. Respects the config file name setting
	 *
	 * @param $foldername
	 * @return string
	 */
	protected function getFullPathToConfigFile($foldername) {
		$configFileName = 'gallery.conf';

		if ($GLOBALS['parameter']['galleryConfigFile']) {
			$configFileName = $GLOBALS['parameter']['galleryConfigFile'];
		}

		return $foldername.'/'.$configFileName;
	}

	/**
	 * Returns true if at least one image file exists in the folder, false if otherwise
	 *
	 * @param $foldername
	 * @return bool
	 */
	protected function validateAtLeastOnePictureFileExists($foldername) {
		$fileHandler = new \Kaba\Gallery\FileHandler\Files();

		$contentsOfFolder = $this->getContentsOfFolder($foldername);

		foreach ($contentsOfFolder as $file) {
			if ($fileHandler->validateFileIsImage($file)) {
				return TRUE;
			}
		}

		return FALSE;
}

	/**
	 * Unsets every folderContent-array entry which isn't a image file and resets the array keys
	 *
	 * @param $folderContent
	 * @return array
	 */
	public function limitResultToImages($folderContent) {
		$fileHandler = new \Kaba\Gallery\FileHandler\Files();

		foreach ($folderContent as $key => $singleFile) {
			if (!$fileHandler->validateFileIsImage($singleFile)) {
				unset($folderContent[$key]);
			}
		}

		$folderContent = array_slice($folderContent, 0);

		return $folderContent;
}

	/**
	 * get the config file from a gallery folder
	 *
	 * @param $foldername
	 * @return array
	 * @throws \Exception
	 */
	public function getConfigFileFromFolder($foldername) {
		if ($this->validateConfigFileExists($foldername)) {
			$configFileContent = file($this->getFullPathToConfigFile($foldername));
			return $configFileContent;
		} else {
			throw new \Exception('No config file found in folder '.$foldername.'. This shouldn\' happen because we filter
			if there are config files earlier, but you never know', 1357772287);
		}
}

	/**
	 * returns true if at least one file exists in the folder, false if otherwise
	 *
	 * @param $path
	 * @return bool
	 */
	private function validateFolderHasAtLeastOneFile($path) {
		$folderContent = scandir($path);
		if (count($folderContent > 0)) {
			return TRUE;
		}
		return FALSE;
	}

}

?>