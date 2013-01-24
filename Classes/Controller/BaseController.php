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

namespace Kabarakh\Mirarse\Controller;

/**
 * The base class for all controllers. Takes care of calling actions and the views
 */
/**
 *
 */
class BaseController extends \Kabarakh\Mirarse\Controller\AbstractController {

	/**
	 * @var \Kabarakh\Mirarse\FileSystemHandler\YamlParser
	 * @inject
	 */
	protected $yamlParser;

	/**
	 * The method to call actions. This method must be used instead of calling the action methods directly,
	 * if not the views can't be used
	 *
	 * @param string $controller
	 * @param string $actionName
	 * @param string $parameter
	 *
	 * @throws \Exception
	 */
	public function callAction($controller, $actionName, $parameter = '') {
		$action = $actionName."Action";
		$controllerObject = NULL;

		// todo: session handler for parameter handling, and not always use this yaml stuff, only when parameter is filled
		$GLOBALS['parameter'] = $this->yamlParser->parseYamlString($parameter);

		try {
			$controllerObject = $this->getObjectForController($controller.'Controller');

			$controllerObject->$action();
		} catch (\Exception $e) {
			throw $e;
		}

		$controllerObject->view->generatePathAutomatically($controller, $actionName);

		$controllerObject->view->render();
	}

	/**
	 * Generates an object to use for the controller actions. If a controller is provided, it uses this one, if not
	 * it uses the same as the controller used to call the action. If AbstractController is used (i.e. no controller
	 * is provided and an action is called outside the controller context) an exception is thrown.
	 *
	 * @param $controller
	 *
	 * @return BaseController
	 * @throws \Exception
	 */
	protected function getObjectForController($controller) {
		if ($controller != NULL) {
			$controllerClassName = __NAMESPACE__ . "\\" . $controller;

			if (!class_exists($controllerClassName)) {
				throw new \Exception('Class not found: ' . $controllerClassName, 1357259410);
			}

			/** @var $controllerObject BaseController */
			$controllerObject = new $controllerClassName();

		} else {

			if (get_class($this) == 'Kabarakh\Mirarse\Controller\BaseController') {
				throw new \Exception('Please set an explicit controller, BaseController is used', 1357349347);
			}

			$controllerObject = clone $this;
		}

		return $controllerObject;

	}

}

?>