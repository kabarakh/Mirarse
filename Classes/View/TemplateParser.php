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
namespace Kabarakh\Mirarse\View;

/**
 * Parses the html template and writes the php cache file
 */
class TemplateParser extends \Kabarakh\Mirarse\ClassMagic\GalleryBaseClass {

	/**
	 * @var \Kabarakh\Mirarse\FileSystemHandler\FileHandler
	 * @inject
	 */
	protected $fileHandler;

	/**
	 * @var string
	 */
	protected $pathToCacheFile;

	/**
	 * @var string
	 */
	protected $cachedViewClassName;

	/**
	 * @var string
	 */
	protected $htmlString = '';

	/**
	 * @var string
	 */
	protected $phpString = '';

	/**
	 * @var \Kabarakh\Mirarse\View\ViewConfig
	 * @inject
	 */
	protected $viewConfig;

	/**
	 * @param \Kabarakh\Mirarse\View\ViewConfig $viewConfig
	 */
	public function setViewConfig($viewConfig) {
		$this->viewConfig = $viewConfig;
	}

	/**
	 * @return \Kabarakh\Mirarse\View\ViewConfig
	 */
	public function getViewConfig() {
		return $this->viewConfig;
	}

	/**
	 * @param string $cachedViewClassName
	 */
	public function setCachedViewClassName($cachedViewClassName) {
		$this->cachedViewClassName = $cachedViewClassName;
	}

	/**
	 * @return string
	 */
	public function getCachedViewClassName() {
		return $this->cachedViewClassName;
	}

	/**
	 * @param string $pathToCacheFile
	 */
	public function setPathToCacheFile($pathToCacheFile) {
		$this->pathToCacheFile = $pathToCacheFile;
	}

	/**
	 * @return string
	 */
	public function getPathToCacheFile() {
		return $this->pathToCacheFile;
	}

	/**
	 * The main method for the parser - builds the whole php string and writes it into a file
	 */
	public function generateCacheFile() {
		$this->generateClassHeader();
		$this->generateMethodHeader();
		$this->getContentOfTemplateFile();
		$this->parseHtmlContent();
		$this->generateMethodFooter();
		$this->generateClassFooter();

		$this->writePhpStringToCacheFile();
	}

	/**
	 * Generate opening php tag, copyright, class phpdoc, and class definition including namespace
	 */
	protected function generateClassHeader() {
		$template = <<<'PHPCLASS'
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
namespace Kabarakh\Mirarse\View;

/**
 *
 */
class %s extends \Kabarakh\Mirarse\View\AbstractCachedView {

PHPCLASS;

		$classHeader = sprintf($template, $this->cachedViewClassName);


		$this->phpString .= $classHeader;
	}

	/**
	 * generate method definition for the renderCached-method which is used to render the cached content
	 * includes phpdoc
	 */
	protected function generateMethodHeader() {
		$methodHeader = <<<'METHOD'

	/**
	 * Really render the cached code
	 *
	 * @return void
	 */
	public function renderCached() {

METHOD;

		$this->phpString .= $methodHeader;
	}

	/**
	 * read the content from the html template
	 */
	protected function getContentOfTemplateFile() {
		$this->htmlString = $this->fileHandler->getContentFromFile($this->viewConfig->getPathToHtml(), TRUE);
	}

	/**
	 * the core function - parse that thing and generate php code
	 */
	protected function parseHtmlContent() {
		// todo: parse!

		var_dump($this->htmlString);
		$this->htmlString = 'echo \''.$this->htmlString.'\';';
		$this->phpString .= $this->htmlString;
	}

	/**
	 * closing bracket for the method
	 */
	protected function generateMethodFooter() {
		$methodFooter = <<<'METHODFOOTER'

	}

METHODFOOTER;

		$this->phpString .= $methodFooter;

	}

	/**
	 * closing bracket and php tag
	 */
	protected function generateClassFooter() {
		$classFooter = <<<'CLASSFOOTER'
}
?>
CLASSFOOTER;

		$this->phpString .= $classFooter;

		var_dump($this->phpString);
	}

	/**
	 * write the php-string to the proper file
	 */
	private function writePhpStringToCacheFile() {
		$fileHandle = fopen($this->pathToCacheFile, 'w+');

		fwrite($fileHandle, $this->phpString);

		fclose($fileHandle);
	}


}

?>