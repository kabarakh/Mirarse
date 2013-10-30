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

use Symfony\Component\Templating;
use Symfony\Component\Templating\Loader\LoaderInterface;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Templating\Storage\Storage;
use Symfony\Component\Templating\Storage\FileStorage;
use Symfony\Component\Templating\Storage\StringStorage;
use Symfony\Component\Templating\Helper\HelperInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * FluidEnvironment: Wrapper class for TYPO3\Fluid's options and loader
 *
 * @author Claus Due <claus@wildside.dk>
 * @api
 */
class FluidEnvironment implements ContainerAwareInterface {

	protected $objectManager;
	protected $options = array();
	protected $loader;
	protected $container;
	protected $kernel;

	/**
	 * @var \Symfony\Bundle\FrameworkBundle\Templating\GlobalVariables
	 */
	protected $globals;

	/**
	 * @param LoaderInterface $loader
	 */
	public function __construct(LoaderInterface $loader = NULL, $options = array(), KernelInterface $kernel) {
		$this->loader = $loader;
		$this->options = $options;
		$this->kernel = $kernel;
		$this->objectManager = new \TYPO3\Fluid\Object\ObjectManager();
	}

	/**
	 * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
	 * @return void
	 */
	public function setContainer(ContainerInterface $container = NULL) {
		$this->container = $container;
	}

	/**
	 * @return array
	 */
	public function getOptions() {
		return $this->options;
	}

	/**
	 * @return array
	 */
	public function getTranslatedTemplatePaths() {
		return $this->translateBundlePathOrPaths($this->options['view']);
	}

	/**
	 * @param mixed $pathOrPaths
	 * @return mixed
	 */
	public function translateBundlePathOrPaths($pathOrPaths) {
		if (is_array($pathOrPaths)) {
			return array_map(array($this, 'translateBundlePathOrPaths'), $pathOrPaths);
		}
		if (strpos($pathOrPaths, '@') === 0) {
			$bundleName = substr($pathOrPaths, 1, strpos($pathOrPaths, '/') - 1);
			$bundlePath = $this->kernel->getBundle($bundleName, TRUE)->getPath();
			return str_replace('@' . $bundleName, $bundlePath, $pathOrPaths);
		}
		return $pathOrPaths;
	}

	/**
	 * @return \TYPO3\Fluid\View\StandaloneView
	 */
	public function getTemplateView() {
		/** @var $view \TYPO3\Fluid\View\StandaloneView */
		$view = $this->objectManager->create('\\TYPO3\\Fluid\\View\\StandaloneView');
		$view->setTemplateCacheDir($this->options['cache']['dir']);
		return $view;
	}

}
