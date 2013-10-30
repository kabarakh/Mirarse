<?php
namespace TYPO3\Fluid\Core\Compiler;

/*                                                                        *
 * This script is backported from the FLOW3 package "TYPO3.Fluid".        *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 *  of the License, or (at your option) any later version.                *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */
/**
 * Abstract Fluid Compiled template.
 *
 * INTERNAL!!
 */
abstract class AbstractCompiledTemplate implements \TYPO3\Fluid\Core\Parser\ParsedTemplateInterface {

	/**
	 * @var array
	 */
	protected $viewHelpersByPositionAndContext = array();

	/**
	 * @var \TYPO3\Fluid\Object\ObjectManagerInterface
	 */
	protected $objectManager;

	/**
	 * @param \TYPO3\Fluid\Object\ObjectManagerInterface $objectManager
	 */
	public function injectObjectManager(\TYPO3\Fluid\Object\ObjectManagerInterface $objectManager) {
		$this->objectManager = $objectManager;
	}

	/**
	 * @var string
	 */
	static protected $defaultEncoding = NULL;

	/**
	 * Public such that it is callable from within closures
	 *
	 * @param integer $uniqueCounter
	 * @param \TYPO3\Fluid\Core\Rendering\RenderingContextInterface $renderingContext
	 * @param string $viewHelperName
	 * @return \TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper
	 * @internal
	 */
	public function getViewHelper($uniqueCounter, \TYPO3\Fluid\Core\Rendering\RenderingContextInterface $renderingContext, $viewHelperName) {
		if (isset($this->viewHelpersByPositionAndContext[$uniqueCounter])) {
			if ($this->viewHelpersByPositionAndContext[$uniqueCounter]->contains($renderingContext)) {
				$viewHelper = $this->viewHelpersByPositionAndContext[$uniqueCounter][$renderingContext];
				$viewHelper->resetState();
				return $viewHelper;
			} else {
				$viewHelperInstance = self::$objectContainer->getInstance($viewHelperName);
				if ($viewHelperInstance instanceof \TYPO3\Fluid\Object\SingletonInterface) {
					$viewHelperInstance->resetState();
				}
				$this->viewHelpersByPositionAndContext[$uniqueCounter]->attach($renderingContext, $viewHelperInstance);
				return $viewHelperInstance;
			}
		} else {
			$this->viewHelpersByPositionAndContext[$uniqueCounter] = new \SplObjectStorage();
			$viewHelperInstance = $this->objectManager->create($viewHelperName);
			if ($viewHelperInstance instanceof \TYPO3\Fluid\Object\SingletonInterface) {
				$viewHelperInstance->resetState();
			}
			$this->viewHelpersByPositionAndContext[$uniqueCounter]->attach($renderingContext, $viewHelperInstance);
			return $viewHelperInstance;
		}
	}

	/**
	 * @return boolean
	 */
	public function isCompilable() {
		return FALSE;
	}

	/**
	 * @return boolean
	 */
	public function isCompiled() {
		return TRUE;
	}

	/**
	 * @return string
	 * @internal
	 */
	static public function resolveDefaultEncoding() {
		if (static::$defaultEncoding === NULL) {
			static::$defaultEncoding = 'UTF-8';
		}
		return static::$defaultEncoding;
	}

}
