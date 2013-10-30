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
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Templating\Storage\Storage;
use Symfony\Component\Templating\Storage\FileStorage;
use Symfony\Component\Templating\Storage\StringStorage;
use Symfony\Component\Templating\Helper\HelperInterface;
use Symfony\Component\Templating\Loader\LoaderInterface;
use Symfony\Bundle\FrameworkBundle\Templating\TemplateNameParser;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Templating\TemplateReference;
use TYPO3\Fluid\View\StandaloneView;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * FluidEngine is an engine able to render Fluid templates.
 *
 * @author Claus Due <claus@wildside.dk>
 * @api
 */
class FluidEngine extends ContainerAware implements EngineInterface, ContainerAwareInterface {

	protected $loader;
	protected $parser;
	protected $environment;

	/**
	 * Constructor.
	 *
	 * @param FluidEnvironment $environment
	 * @param TemplateNameParserInterface $parser  A TemplateNameParser instance
	 * @param LoaderInterface             $loader  A loader instance
	 */
	public function __construct(FluidEnvironment $environment, TemplateNameParser $parser, LoaderInterface $loader) {
		$this->environment = $environment;
		$this->parser = $parser;
		$this->loader = $loader;
	}

	/**
	 * Renders a template.
	 *
	 * @param mixed $name       A template name or a TemplateReferenceInterface instance
	 * @param array $parameters An array of parameters to pass to the template
	 * @return string The evaluated template as a string
	 * @throws \RuntimeException if the template cannot be rendered
	 * @api
	 */
	public function render($name, array $parameters = array()) {
		$templateReference = $this->parser->parse($name);
		/** @var $view StandaloneView */
		$view = $this->environment->getTemplateView();
		$view->assignMultiple($parameters);
		$view->setFormat('html.fluid');
		$this->addTemplateSource($view, $templateReference);
		$this->addTemplateViewPaths($view);

		#var_dump($translatedPaths);
		#var_dump($this->environment->)
		return $view->render();
	}

	/**
	 * Returns true if the template exists.
	 *
	 * @param mixed $name A template name or a TemplateReferenceInterface instance
	 * @return Boolean true if the template exists, false otherwise
	 * @api
	 */
	public function exists($name) {
		return $this->loader->load($this->parser->parse($name)) !== FALSE;
	}

	/**
	 * Returns true if this class is able to render the given template.
	 *
	 * @param mixed $name A template name or a TemplateReferenceInterface instance
	 * @return Boolean true if this class supports the given template, false otherwise
	 * @api
	 */
	public function supports($name) {
		$reference = $this->parser->parse($name)->all();
		return $reference['engine'] === 'fluid';
	}

	/**
	 * Renders a view and returns a Response.
	 *
	 * @param string   $view       The view name
	 * @param array    $parameters An array of parameters to pass to the view
	 * @param Response $response   A Response instance
	 * @return Response A Response instance
	 */
	public function renderResponse($view, array $parameters = array(), Response $response = NULL) {
		if (NULL === $response) {
			$response = new Response();
		}
		$response->setContent($this->render($view, $parameters));
		return $response;
	}

	/**
	 * @param \TYPO3\Fluid\View\StandaloneView $view
	 * @param \Symfony\Bundle\FrameworkBundle\Templating\TemplateReference $templateReference
	 * @return void
	 */
	protected function addTemplateSource(StandaloneView &$view, TemplateReference $templateReference) {
		$translatedPaths = $this->environment->getTranslatedTemplatePaths();
		$templateRootPath = $translatedPaths['templateRootPath'];
		list ($bundleName, $controllerName, $file) = explode(':', $templateReference->getLogicalName());
		list ($action, $format, $engine) = explode('.', $file);
		$templatePathAndFilename = $templateRootPath . $controllerName . '/' . $action . '.' . $format . '.' . $engine;
		$view->setTemplatePathAndFilename($templatePathAndFilename);
	}

	/**
	 * @param \TYPO3\Fluid\View\StandaloneView $view
	 * @return void
	 */
	protected function addTemplateViewPaths(StandaloneView &$view) {
		$translatedPaths = $this->environment->getTranslatedTemplatePaths();
		$view->setPartialRootPath($translatedPaths['partialRootPath']);
		$view->setLayoutRootPath($translatedPaths['layoutRootPath']);
	}

}
