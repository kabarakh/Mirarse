<?php
namespace TYPO3\Fluid;

/*                                                                        *
 * This script is part of the TYPO3 project - inspiring people to share!  *
 *                                                                        *
 * TYPO3 is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License version 2 as published by  *
 * the Free Software Foundation.                                          *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General      *
 * Public License for more details.                                       *
 *                                                                        */
/**

 */
class FluidTemplate implements \TYPO3\Fluid\View\ViewInterface {

	/**
	 * @var \TYPO3\Fluid\View\StandaloneView
	 */
	protected $view;

	/**
	 * @var \TYPO3\Fluid\Object\ObjectManagerInterface
	 */
	protected $objectManager;

	/**
	 * @param string $templateFile
	 * @param array $variables
	 * @param string $layoutRootPath
	 * @param string $partialRootPath
	 */
	public function __construct($templateFile=NULL, array $variables=array(), $layoutRootPath=NULL, $partialRootPath=NULL) {
		$this->objectManager = new \TYPO3\Fluid\Object\ObjectManager();
		$this->view = $this->objectManager->create('\\TYPO3\\Fluid\\View\\StandaloneView');
		if ($templateFile !== NULL) {
			$this->view->setTemplatePathAndFilename($templateFile);
		}
		if (count($variables) > 0) {
			$this->view->assignMultiple($variables);
		}
		if ($layoutRootPath) {
			$this->view->setLayoutRootPath($layoutRootPath);
		}
		if ($partialRootPath) {
			$this->view->setPartialRootPath($partialRootPath);
		}
	}

	/**
	 * Add a variable to the view data collection.
	 * Can be chained, so $this->view->assign(..., ...)->assign(..., ...); is possible
	 *
	 * @param string $key Key of variable
	 * @param mixed $value Value of object
	 * @return \TYPO3\Fluid\View\ViewInterface an instance of $this, to enable chaining
	 * @api
	 */
	public function assign($key, $value) {
		$this->view->assign($key, $value);
	}

	/**
	 * Add multiple variables to the view data collection
	 *
	 * @param array $values array in the format array(key1 => value1, key2 => value2)
	 * @return \TYPO3\Fluid\View\ViewInterface an instance of $this, to enable chaining
	 * @api
	 */
	public function assignMultiple(array $values) {
		$this->view->assignMultiple($values);
	}

	/**
	 * Renders the view
	 *
	 * @return string The rendered view
	 * @api
	 */
	public function render() {
		return $this->view->render();
	}

	/**
	 * Initializes this view.
	 *
	 * @return void
	 * @api
	 */
	public function initializeView() {
		$this->view->initializeView();
	}

	/**
	 * @param string $layoutRootPath
	 */
	public function setLayoutRootPath($layoutRootPath) {
		$this->view->setLayoutRootPath($layoutRootPath);
	}

	/**
	 * @return string
	 */
	public function getLayoutRootPath() {
		return $this->view->getLayoutRootPath();
	}

	/**
	 * @param string $partialRootPath
	 */
	public function setPartialRootPath($partialRootPath) {
		$this->view->setPartialRootPath($partialRootPath);
	}

	/**
	 * @return string
	 */
	public function getPartialRootPath() {
		return $this->view->getPartialRootPath();
	}

	/**
	 * @param string $templatePathAndFilename
	 */
	public function setTemplatePathAndFilename($templatePathAndFilename) {
		$this->view->setTemplatePathAndFilename($templatePathAndFilename);
	}

	/**
	 * @return string
	 */
	public function getTemplatePathAndFilename() {
		return $this->view->getTemplatePathAndFilename();
	}

	/**
	 * @param string $templateSource
	 */
	public function setTemplateSource($templateSource) {
		$this->view->setTemplateSource($templateSource);
	}

}
