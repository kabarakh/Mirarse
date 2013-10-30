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
namespace Kabarakh\Mirarse\Utility;

class Utility extends \Kabarakh\Mirarse\ClassMagic\GalleryBaseClass implements \Kabarakh\Mirarse\ClassMagic\SingletonInterface {

	public function trimExplode($string, $delimiter = ' ', $removeEmptyParts = FALSE, $limit = 0) {

		$string = trim($string);

		$explodedArray = explode($delimiter, $string, $limit);

		foreach ($explodedArray as &$part) {
			trim($part);
		}

		if ($removeEmptyParts) {
			$explodedArray = $this->removeEmptyArrayParts($explodedArray);
		}

		return $explodedArray;
	}

	public function removeEmptyArrayParts($array) {
		foreach ($array as $key => $part) {
			if (empty($part)) {
				unset($array[$key]);
			}
		}
		return $array;
	}

}
?>