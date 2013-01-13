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
namespace Kaba\Gallery\FileSystemHandler;

/**
 * Everything that has to do with folder content arrays
 */
class FolderContentHandler extends \Kaba\Gallery\ClassMagic\GalleryBaseClass {

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
	 * @var \Kaba\Gallery\FileSystemHandler\Validator\FolderValidator
	 * @inject
	 */
	protected $folderValidator;

	/**
	 * @var \Kaba\Gallery\FileSystemHandler\FolderHandler
	 * @inject
	 */
	protected $folderHandler;

	/**
	 * @var array
	 */
	protected $content = array();

	/**
	 * @param $path string
	 */
	public function __construct($path) {
		$this->content = scandir($path);
		parent::__construct();
	}

	/**
	 * @param array $content
	 */
	public function setContent($content) {
		$this->content = $content;
	}

	/**
	 * @return array
	 */
	public function getContent() {
		return $this->content;
	}

	/**
	 * Removes "." and ".." from an folder content array
	 *
	 * Resets the array keys to start from 0 with array_slice
	 */
	public function removeDotDirectoriesFromFolderContent() {
		unset($this->content[array_search('.', $this->content)]);
		unset($this->content[array_search('..', $this->content)]);

		$this->content = array_slice($this->content, 0);
	}

	/**
	 * Filters a folder content array so that everything except folders is removed from the array
	 *
	 * Resets the array keys to start from 0 with array_slice
	 */
	public function limitResultToFolders() {
		foreach ($this->content as $key => $filename) {
			if (!is_dir($filename)) {
				unset($this->content[$key]);
			}
		}
	}

	/**
	 * Unsets every folderContent-array entry which isn't a image file and resets the array keys
	 *
	 * @return void
	 */
	public function limitResultToImages() {
		foreach ($this->content as $key => $singleFile) {
			if (!$this->fileValidator->validateFileIsImage($singleFile)) {
				unset($this->content[$key]);
			}
		}

		$this->content = array_slice($this->content, 0);
	}

	/**
	 * Filters a folder content array so that everything except valid gallery folders is removed from the array
	 *
	 * A valid folder for the gallery consists of at least one picture and the config file (name gallery.conf, can be
	 * overridden while calling an action)
	 *
	 */
	public function limitResultToValidFolders() {

		foreach ($this->content as $key => $path) {

			$configFileExists = $this->fileValidator->validateFileExists($this->folderHandler->getFullPathToConfigFile($path));
			$onePictureExists = $this->folderValidator->validateAtLeastOnePictureFileExists($path);

			if (!$configFileExists || !$onePictureExists) {
				unset($this->content[$key]);
			}
		}

		$this->content = array_slice($this->content, 0);

	}

}

?>