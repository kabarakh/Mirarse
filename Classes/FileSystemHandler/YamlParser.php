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
use \Symfony\Component\Yaml\Yaml;

/**
 * Everything that has to do with yaml config parsing (maybe this will be refactored to "everything that has to do with yaml"
 * and the parsing is only part of it
 */
class YamlParser extends \Kabarakh\Mirarse\ClassMagic\GalleryBaseClass implements \Kabarakh\Mirarse\ClassMagic\SingletonInterface {


	public function parseYamlFile($path, $exceptionOnInvalidType = false, $objectSupport = false) {
		try {
			$yamlContent = Yaml::parse($path, $exceptionOnInvalidType, $objectSupport);
			return $yamlContent;
		} catch (\Exception $e) {
			throw new \Exception('Config file with path '.$path.' empty or malformed yaml', 1358189377);
		}
	}

	public function parseYamlString($yamlString, $exceptionOnInvalidType = false, $objectSupport = false) {
		try {
			$yamlContent = Yaml::parse($yamlString, $exceptionOnInvalidType, $objectSupport);
			return $yamlContent;
		}
		catch (\Exception $e) {
			throw new \Exception('Config string was malformed or empty', 1358189382);
		}
	}

	public function arrayToYaml($dataArray, $inline = 2, $indent = 4, $exceptionOnInvalidType = false, $objectSupport = false) {
		try {
			$yamlContent = Yaml::dump($dataArray, $inline , $indent, $exceptionOnInvalidType, $objectSupport);
			return $yamlContent;
		} catch (\Exception $e) {
			throw new \Exception('Array could not be converted to yaml string', 1371245796);
		}
	}
}

?>