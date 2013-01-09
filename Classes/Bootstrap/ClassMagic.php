<?php

namespace Kaba\Gallery\Bootstrap;

class ClassMagic {
	public function resolveInjects($classObj) {
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
	}

	protected function generatePropertyNameOutOfInject($classVariable) {
		$classVariable = str_replace('inject', '', $classVariable);
		$classVariable = lcfirst($classVariable);
		return $classVariable;
	}
}

?>