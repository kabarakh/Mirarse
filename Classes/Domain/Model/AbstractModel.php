<?php

namespace Kaba\Gallery\Domain\Model;

abstract class AbstractModel {

	public function getObjectFromArray($objectArray) {

		if (self::validateObjectArray($objectArray)) {

			echo 'Creating object of class '.__CLASS__."\n";

		};

	}

	protected function validateObjectArray($objectArray) {
	}

}

?>