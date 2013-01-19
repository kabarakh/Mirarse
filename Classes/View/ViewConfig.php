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
namespace Kabarakh\Mirarse\View;

/**
 *
 */
class ViewConfig extends \Kabarakh\Mirarse\ClassMagic\GalleryBaseClass {

	/**
	 * @var string
	 */
	protected $controller = '';

	/**
	 * @var string
	 */
	protected $action = '';

	/**
	 * @var array
	 */
	protected $toDisplay = array();

	/**
	 * @var string
	 */
	protected $pathToHtml = '';

	/**
	 * @param string $action
	 */
	public function setAction($action) {
		$this->action = $action;
	}

	/**
	 * @return string
	 */
	public function getAction() {
		return $this->action;
	}

	/**
	 * @param string $controller
	 */
	public function setController($controller) {
		$this->controller = $controller;
	}

	/**
	 * @return string
	 */
	public function getController() {
		return $this->controller;
	}

	/**
	 * @param string $pathToHtml
	 */
	public function setPathToHtml($pathToHtml) {
		$this->pathToHtml = $pathToHtml;
	}

	/**
	 * @return string
	 */
	public function getPathToHtml() {
		return $this->pathToHtml;
	}

	/**
	 * @param array $toDisplay
	 */
	public function setToDisplay($toDisplay) {
		$this->toDisplay = $toDisplay;
	}

	/**
	 * @return array
	 */
	public function getToDisplay() {
		return $this->toDisplay;
	}


	/**
	 * @param $name
	 * @param $object
	 */
	public function addToToDisplay($name, $object) {
		$this->toDisplay[$name] = $object;
	}

	/**
	 * @param $name
	 */
	public function removeFromToDisplay($name) {
		unset($this->toDisplay[$name]);
	}

}

?>