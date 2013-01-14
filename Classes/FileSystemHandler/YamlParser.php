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
 * Everything that has to do with yaml config parsing (maybe this will be refactored to "everything that has to do with yaml"
 * and the parsing is only part of it
 */
class YamlParser {

	/**
	 * Takes the path to the file, reads the yaml content and returns an array with the content
	 *
	 * @param $path string
	 * @throws \Exception
	 * @return array
	 */
	public function parseYamlFile($path) {
		$yamlContent = yaml_parse_file($path);

		if (!count($yamlContent)) {
			throw new \Exception('Config file with path '.$path.' empty or malformed yaml', 1358189377);
		}

		return $yamlContent;
	}

	/**
	 * Takes a string and parses it as yaml content, returns an array with the content
	 *
	 * @param $yamlString string
	 * @throws \Exception
	 * @return array
	 */
	public function parseYamlString($yamlString) {
		$yamlContent = yaml_parse($yamlString);

		if (!count($yamlContent)) {
			throw new \Exception('Config string was malformed or empty', 1358189382);
		}

		return $yamlContent;
	}
}

?>