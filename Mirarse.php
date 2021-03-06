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

namespace Kabarakh;

/**
 * The main class for the gallery. Starts the whole thing and contains the controllers
 */
class Mirarse {

	/**
	 * @var \Kabarakh\Mirarse\Controller\BaseController
	 */
	public $controller;

	/**
	 * Starts the gallery. After calling this method you have access to the controllers
	 *
	 * @return void
	 */
	public function start() {

		// get the bootstrap and initialize everything
		require_once dirname(__FILE__)."/Classes/Bootstrap/Initializer.php";

		$bootstrap = new \Kabarakh\Mirarse\Bootstrap\Initializer();
		$bootstrap->init();

		$this->controller = new \Kabarakh\Mirarse\Controller\BaseController();

	}

	/**
	 * Wrapper for $this->controller->callAction to make the script more usable
	 *
	 * @param string $controller
	 * @param string $actionName
	 * @param string $parameter
	 */
	public function callAction($controller, $actionName, $parameter = '') {
		if ($_GET['Mirarse']['controller'] && $_GET['Mirarse']['action']) {
			$controller = $_GET['Mirarse']['controller'];
			$actionName = $_GET['Mirarse']['action'];
		}
		$this->controller->callAction($controller, $actionName, $parameter);
	}

}

// this is put here so the user can just include this file and use $gallery->callAction
$mirarse = new \Kabarakh\Mirarse();
$mirarse->start();

?>