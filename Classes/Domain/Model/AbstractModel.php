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

namespace Kabarakh\Mirarse\Domain\Model;

/**
 * The abstract model class to provide functionality for the specific models
 */
abstract class AbstractModel extends \Kabarakh\Mirarse\ClassMagic\GalleryBaseClass {

	/**
	 * create a model object from an array. validates if all keys and data types are correct
	 * and then builds an object for the class
	 *
	 * @param $objectArray
	 */
	public function getObjectFromArray($objectArray) {

		if (self::validateObjectArray($objectArray)) {

		};

	}

	/**
	 * checks if the keys and data types from the array entries fit to the model class
	 *
	 * @param $objectArray
	 */
	protected function validateObjectArray($objectArray) {
	}

}

?>