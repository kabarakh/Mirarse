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
 * Everything which has to do with file handling
 */
class FileHandler extends \Kabarakh\Mirarse\ClassMagic\GalleryBaseClass {

	/**
	 * @var \Kabarakh\Mirarse\FileSystemHandler\Validator\FileValidator
	 * @inject
	 */
	protected $fileValidator;

	/**
	 * @var \Kabarakh\Mirarse\FileSystemHandler\YamlParser
	 * @inject
	 */
	protected $yamlParser;

	/**
	 * Returns the content from a file as an array
	 * Validates first if the file exists
	 *
	 * @param $pathOfConfigFile
	 *
	 * @return array
	 * @throws \Exception
	 */
	public function getContentFromFile($pathOfConfigFile) {
		if ($this->fileValidator->validateFileExists($pathOfConfigFile)) {
			return $configFileContent = file($pathOfConfigFile);
		} else {
			throw new \Exception('No config file found with path ' . $pathOfConfigFile . '. This should not happen because we filter
			if there are config files earlier, but you never know', 1357772287);
		}
	}

	/**
	 * Reads a yaml config file and returns the array after parsing it
	 * checks first if the file exists (basically unnecessary but you never know...) and if the file is not empty
	 *
	 * @param $pathOfConfigFile
	 *
	 * @return array|null
	 * @throws \Exception
	 */
	public function getConfigArrayFromYamlFile($pathOfConfigFile) {
		if ($this->fileValidator->validateFileExists($pathOfConfigFile)) {
			if ($this->fileValidator->validateIfFileIsNotEmpty($pathOfConfigFile)) {
				return $configFileContent = $this->yamlParser->parseYamlFile($pathOfConfigFile);
			} else {
				return NULL;
			}
		} else {
			throw new \Exception('No config file found with path ' . $pathOfConfigFile . '. This should not happen because we filter
				if there are config files earlier, but you never know', 1357772287);
		}
	}
}

?>