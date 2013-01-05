<?php

namespace Kaba;

/**
 * The main class for the gallery. Starts the whole thing and contains the controllers
 */
class Gallery {

	/**
	 * @var \Kaba\Gallery\Controller\AbstractController
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

		$bootstrap = new Gallery\Bootstrap\Initializer();
		$bootstrap->init();

		$this->controller = new \Kaba\Gallery\Controller\AbstractController();

	}

	public function callAction($actionName, $parameter = array(), $controller = NULL) {
		$this->controller->callAction($actionName, $parameter, $controller);
	}

}

$gallery = new \Kaba\Gallery();

$gallery->start();
?>