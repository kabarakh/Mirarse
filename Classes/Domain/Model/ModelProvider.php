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
 * Generic provider for domain model object
 */
class ModelProvider extends \Kabarakh\Mirarse\ClassMagic\GalleryBaseClass {

	/**
	 * @var \Kabarakh\Mirarse\ClassMagic\ClassMagic
	 * @inject
	 */
	protected $classMagic;

	/**
	 * create a model object from an array. validates if all keys and data types are correct
	 * and then builds an object for the class
	 *
	 * @param $modelType
	 * @param $objectArray
	 *
	 * @return null|object
	 */
	public function getObjectFromArray($modelType, $objectArray) {
		if (self::validateObjectArray($modelType, $objectArray)) {
			$classObject = new $modelType();
			foreach ($objectArray as $parameter => $value) {
				$setterName = 'set'.ucfirst($parameter);
				$classObject->$setterName($value);
			}
			return $classObject;

		}
		return NULL;
	}

	/**
	 * checks if the keys and data types from the array entries fit to the model class
	 *
	 * @param $className string
	 * @param $objectArray array
	 *
	 * @return bool
	 */
	protected function validateObjectArray($className, $objectArray) {
		$reflectionClass = new \ReflectionClass($className);

		$propertiesToReflect = $reflectionClass->getProperties();

		if (self::validatePropertyNames($propertiesToReflect, array_keys($objectArray)) && self::validatePropertyTypes($propertiesToReflect, $objectArray)) {
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Validates if all property names of the class we want to create are in the objectArray. counts entries and
	 * compares the names
	 *
	 * @param $propertiesToReflect
	 * @param $objectArrayKeys
	 *
	 * @return bool
	 * @throws \Exception
	 */
	protected function validatePropertyNames($propertiesToReflect, $objectArrayKeys) {
		$propertyNames = array();

		foreach ($propertiesToReflect as $property /** @var \ReflectionProperty $property */) {
			$propertyNames[] = $property->getName();
		}

		sort($objectArrayKeys);
		sort($propertyNames);

		if (count($objectArrayKeys) !== count($propertyNames)) {
			throw new \Exception('ObjectArray and PropertyNames have different lengths', 1358201663);
		}

		$diff1 = array_diff($objectArrayKeys, $propertyNames);
		$diff2 = array_diff($propertyNames, $objectArrayKeys);

		if (count($diff1) !== 0 || count($diff2) !== 0) {
			throw new \Exception('ObjectArray and PropertyNames differ', 1358201672);
		}

		return TRUE;
	}

	/**
	 * Checks if the properties to set in the new object and the entries of the object array are of the same types
	 *
	 * @param $propertiesToReflect
	 * @param $objectArray
	 *
	 * @return bool
	 * @throws \Exception
	 */
	protected function validatePropertyTypes($propertiesToReflect, $objectArray) {

		foreach ($propertiesToReflect as $property) {
			/** @var \ReflectionProperty $property */
			$typeOfProperty = $this->classMagic->getPropertyTypeFromDocComment($property->getDocComment());
			$typeOfArrayEntry = gettype($objectArray[$property->getName()]);
			if ($typeOfArrayEntry === 'object') {
				$typeOfArrayEntry = '\\'.get_class($objectArray[$property->getName()]);
			}

			if ($typeOfProperty !== $typeOfArrayEntry) {
				throw new \Exception('Type of property '.$property->getName()." does not match type in object array", 1358201678);
			}
		}

		return TRUE;
	}
}

?>