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

use Neos\Utility\Arrays;

/**
 *
 */
class BaseController extends \Kabarakh\Mirarse\Controller\AbstractController {

	/**
	 * @var \Kabarakh\Mirarse\Bootstrap\ConfigurationHandler
	 * @inject
	 */
	protected $configurationHandler;

	/**
	 * @var \Kabarakh\Mirarse\FileSystemHandler\Validator\FileValidator
	 * @inject
	 */
	protected $fileValidator;

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

		$this->configurationHandler->mergeStandardAndUserConfig($parameter);

		try {
			$controllerObject = $this->getObjectForController($controller.'Controller');

			$controllerObject->$action();
		} catch (\Exception $e) {
			throw $e;
		}

		$this->generatePathForViewAutomatically($controller, $actionName, $controllerObject->view);

		echo $controllerObject->view->render();

		return;
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


	/**
	 * Override the automatically generated paths to the html files - even if you use the config to use another
	 * root directory
	 *
	 * @param $path
	 */
	public function setNonStandardPathForView($path) {
		if ($this->fileValidator->validateFileExists($path)) {
			$templatePaths = $this->view->getRenderingContext()->getTemplatePaths();
			$templatePaths->setTemplatePathAndFilename($path);
		}
	}

	/**
	 * Use controller and action to generate a path
	 * Because this has to work it throws an exception if file isn't present
	 * If nonStandardPath is set earlier, this method does nothing
	 *
	 * @param $controller
	 * @param $action
     * @param $view
	 * @throws \Exception
	 */
	public function generatePathForViewAutomatically($controller, $action, $view = null) {
	    if (!$view) {
	        $view = $this->view;
        }
	    $renderingContext = $view->getRenderingContext();
	    $renderingContext->getTemplatePaths()->setTemplateRootPaths([$this->getBaseTemplateFolder()]);
	    $renderingContext->setControllerName($controller);
	    $renderingContext->setControllerAction($action);
	    $view->setRenderingContext($renderingContext);
	}

	/**
	 * Reads the config string and builds the path to the template files according to it
	 * if no config is set, use standard templates folder
	 *
	 * @return string
	 */
	protected function getBaseTemplateFolder() {
	    $templateRootPath = Arrays::getValueByPath($GLOBALS, 'parameter.templateRootPath');
		if ($templateRootPath) {
			return MIRARSE_RUN_DIRECTORY.$templateRootPath.'/';
		}
		return MIRARSE_TEMPLATES;
	}

	/**
	 * Reads the config string and builds the path to the template files according to it
	 * if no config is set, use standard templates folder
	 *
	 * @return string
	 */
	protected function getBaseLayoutFolder() {
		if ($GLOBALS['parameter']['layoutRootPath']) {
			return MIRARSE_RUN_DIRECTORY.$GLOBALS['parameter']['layoutRootPath'].'/';
		}
		return MIRARSE_LAYOUTS;
	}

	/**
	 * Reads the config string and builds the path to the template files according to it
	 * if no config is set, use standard templates folder
	 *
	 * @return string
	 */
	protected function getBasePartialFolder() {
		if ($GLOBALS['parameter']['partialRootPath']) {
			return MIRARSE_RUN_DIRECTORY.$GLOBALS['parameter']['partialRootPath'].'/';
		}
		return MIRARSE_PARTIALS;
	}

}

?>