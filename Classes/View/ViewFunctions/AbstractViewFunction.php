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
namespace Kabarakh\Mirarse\View\ViewFunctions;

abstract class AbstractViewFunction extends \Kabarakh\Mirarse\ClassMagic\GalleryBaseClass {
	/**
	 * @var Kabarakh\Mirarse\View\ObjectParser
	 * @inject
	 */
	protected $objectParser;

	protected $properties = array();

	public function __set($name, $value) {
		$this->properties[$name] = $value;
	}

	public function __get($name) {
		if (array_key_exists($name, $this->properties)) {
			return $this->properties[$name];
		} else {
			return NULL;
		}
	}

	public function __construct($properties = array()) {
		parent::__construct();

		foreach ($properties as $nameAndValue) {
			list($name, $value) = explode('=', $nameAndValue);
			if (!$name || !$value) {
				throw new \Exception('Error while rendering '.get_class($this).' in property/value '.$nameAndValue);
			} else {
				$this->$name = $value;
			}
		}
	}

	abstract function render();

	abstract function validateParameter();

}
?>