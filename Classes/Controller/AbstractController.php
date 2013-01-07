<?php

namespace Kaba\Gallery\Controller;

/**
 * The base class for all controllers. Takes care of calling actions and the views
 */
/**
 *
 */
class AbstractController {

	/**
	 * @var \Kaba\Gallery\Controller\ControllerView
	 */
	protected $view;

	/**
	 * Initialize the controller
	 */
	public function __construct() {
		$this->view = new \Kaba\Gallery\Controller\ControllerView();
	}

	/**
	 * The method to call actions. This method must be used instead of calling the action methods directly,
	 * if not the views can't be used
	 *
	 * @param $actionName
	 * @param $parameter
	 * @param null $controller
	 *
	 * @throws \Exception
	 */
	public function callAction($actionName, $parameter = array(), $controller = NULL) {
		$action = $actionName."Action";

		$GLOBALS['parameter'] = $parameter;

		echo "Called class: ".get_called_class(). "\n";
		echo "Action: ".$action."\n";
		echo "Parameters: ".print_r($GLOBALS['parameter'], TRUE);

		echo "Calling ".get_called_class().'->'.$action."\n";

		try {
			$controllerObject = $this->getObjectForController($controller);

			$controllerObject->$action();
		} catch (\Exception $e) {
			die("Error: ".$e);
		}

		$this->view->render();
	}

	/**
	 * Generates an object to use for the controller actions. If a controller is provided, it uses this one, if not
	 * it uses the same as the controller used to call the action. If AbstractController is used (i.e. no controller
	 * is provided and an action is called outside the controller context) an exception is thrown.
	 *
	 * @param $controller
	 *
	 * @return AbstractController
	 * @throws \Exception
	 */protected function getObjectForController($controller) {
		if ($controller != NULL) {
			$controllerClassName = __NAMESPACE__ . "\\" . $controller;

			if (!class_exists($controllerClassName)) {
				throw new \Exception('Class not found: ' . $controllerClassName, 1357259410);
			}

			/** @var $controllerObject AbstractController */
			$controllerObject = new $controllerClassName();

		} else {

			if (get_class($this) == 'Kaba\Gallery\Controller\AbstractController') {
				throw new \Exception('Please set an explicit controller, AbstractController is used', 1357349347);
			}

			$controllerObject = clone $this;
		}

		return $controllerObject;

	}

}

?>
