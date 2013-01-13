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

namespace Kaba\Gallery\Bootstrap;

/**
 * Some magic stuff like injects
 */
class ClassMagic {

	/**
	 * Gets all properties from a class with var and inject phpdoc annotations and resolves them.
	 * just builds basic objects of the proper type and sets them to the property
	 *
	 * @param $classObj
	 */
	public function resolveInjects($classObj) {

		$injectProperties = $this->getInjectProperties($classObj);

		foreach ($injectProperties as $propertyEntry) {
			$objectToInject = new $propertyEntry['type']();

			$propertyEntry['property']->setAccessible(TRUE);
			$propertyEntry['property']->setValue($classObj, $objectToInject);
		}

	}

	/**
	 * Gets all properties with the proper annotations
	 *
	 * @param $object
	 *
	 * @return array
	 */
	protected function getInjectProperties($object) {
		$reflectionClass = new \Kaba\Gallery\ClassMagic\Reflection\ReflectionClass($object);

		$properties = $reflectionClass->getProperties();
		$propertiesToInject = array();
		foreach ($properties as $property) {/** @var $property \Kaba\Gallery\ClassMagic\Reflection\ReflectionProperty */
			$docComment = $property->getDocComment();

			if (strpos($docComment, '@inject')) {
				$type = $this->getPropertyTypeFromDocComment($docComment);

				$propertiesToInject[] = array('property' => $property, 'type' => $type);
			}

		}

		return $propertiesToInject;
}

	/**
	 * Gets the var-annotation from the phpdoc comments and parses it to get the right class for the property
	 *
	 * @param $docComment
	 * @return mixed
	 * @throws \Exception
	 */
	protected function getPropertyTypeFromDocComment($docComment) {
		$docCommentLines = explode(chr(10), $docComment);

		foreach ($docCommentLines as $singleLine) {
			if (strpos($singleLine, '@var')) {
				$singleLine = trim($singleLine);
				$singleLineArray = explode(' ', $singleLine);
				return $singleLineArray[2];
			}
		}

		throw new \Exception('@inject found but no @var was given', 1357950694);
	}
}

?>