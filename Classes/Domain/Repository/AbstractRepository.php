<?php

namespace Kaba\Gallery\Domain\Repository;

abstract class AbstractRepository {

	protected $magicProperties = array();

	public function __construct() {
		echo "\nRunning construct of abstractRepo\n\n";

		$classMagic = new \Kaba\Gallery\Bootstrap\ClassMagic();
		$classMagic->resolveInjects($this);

	}

	public function __toString() {
		return get_class($this);
	}

	public function __set($property, $content) {
		$this->magicProperties[$property] = $content;
	}

	public function __get($property) {
		if (array_key_exists($property, $this->magicProperties)) {
			return $this->magicProperties[$property];
		} else {
			throw new \Exception('Magic Property '.$property.' wasn\'t __set() before', 1357770909);
		}
	}

}
?>