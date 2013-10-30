<?php

namespace TYPO3\Fluid\Loader;

use Symfony\Component\Templating\TemplateReferenceInterface;
use Symfony\Component\Templating\Storage\Storage;
use Symfony\Component\Templating\Storage\FileStorage;
use Symfony\Component\Templating\Loader\Loader;
use Symfony\Component\Config\Exception\FileLoaderLoadException;
use Symfony\Component\Templating\TemplateNameParserInterface;
use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\Templating\Loader\LoaderInterface;
use Symfony\Component\Templating\Loader\FilesystemLoader as BaseFilesystemLoader;
/**
 * FilesystemLoader for Fluid
 */
class FilesystemLoader extends BaseFilesystemLoader implements LoaderInterface {

	protected $locator;
	protected $parser;
	protected $configuration;

	/**
	 * Constructor.
	 *
	 * @param FileLocatorInterface        $locator A FileLocatorInterface instance
	 * @param TemplateNameParserInterface $parser  A TemplateNameParserInterface instance
	 * @param array $configuration
	 */
	public function __construct(FileLocatorInterface $locator, TemplateNameParserInterface $parser, $configuration = array()) {
		$this->locator = $locator;
		$this->parser = $parser;
		$this->configuration = $configuration;
	}

	/**
	 * @param \Symfony\Component\Templating\TemplateReferenceInterface $template
	 * @return bool|\Symfony\Component\Templating\Loader\Storage|\Symfony\Component\Templating\Storage\Storage
	 */
	public function load(TemplateReferenceInterface $template) {
		$filename = $this->locator->locate($template);
		$template->set('name', $filename);
		return parent::load($template);
	}


}
