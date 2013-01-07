<?php

namespace Kaba\Gallery\Controller;

abstract class AbstractController {

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
	public abstract function callAction($actionName, $parameter = array(), $controller = NULL);
}
