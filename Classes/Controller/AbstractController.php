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

namespace Kaba\Gallery\Controller;

/**
 * The basic abstract controller to provide functionality to specific controllers
 */
abstract class AbstractController extends \Kaba\Gallery\ClassMagic\GalleryBaseClass {

	/**
	 * @var \Kaba\Gallery\Controller\ControllerView
	 */
	protected $view;

	/**
	 * Initialize the controller
	 */
	public function __construct() {
		$this->view = new \Kaba\Gallery\Controller\ControllerView();

		parent::__construct();
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
