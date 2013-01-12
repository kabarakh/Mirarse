<?php

namespace Kaba\Gallery\Bootstrap;

class ClassMagic {
	public function resolveInjects($classObj) {
		/*
		$className = get_class($classObj);
		$classVariables = get_class_vars($className);
		var_dump($classVariables);
		foreach ($classVariables as $classVariable => $type) {
			if (strncmp($classVariable, 'inject', 6) === 0) {
				echo 'Running '.$classVariable."\n";

				echo 'Build new object for '.$type."\n";
				$object = new $type();

				$propertyName = $this->generatePropertyNameOutOfInject($classVariable);

				echo 'Assigning object to property '.$propertyName."\n";

				$classObj->$propertyName = $object;
			}
		}
		*/

		$injectProperties = $this->getInjectProperties($classObj);

		foreach ($injectProperties as $propertyEntry) {
			echo "\n\n".$propertyEntry['property']->getName()."\n\n";

			$objectToInject = new $propertyEntry['type']();

			echo "Injecting object of type ".$type.' in property '.get_class($classObj)."->".$propertyEntry['property']->getName()."\n";

			$propertyEntry['property']->setAccessible(TRUE);
			$propertyEntry['property']->setValue($classObj, $objectToInject);
		}

	}

	protected function getInjectProperties($object) {
		$reflectionClass = new \Kaba\Gallery\ClassMagic\Reflection\ReflectionClass($object);

		$properties = $reflectionClass->getProperties();
		$propertiesToInject = array();
		foreach ($properties as $property) {/** @var $property \Kaba\Gallery\ClassMagic\Reflection\ReflectionProperty */
			echo "\nProperty name: ".$property->getName()."\n";
			$docComment = $property->getDocComment();

			if (strpos($docComment, '@inject')) {
				echo "@inject in comment for property ".$property->getName();
				$type = $this->getPropertyTypeFromDocComment($docComment);

				$propertiesToInject[] = array('property' => $property, 'type' => $type);
			}

		}

		return $propertiesToInject;
	}

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