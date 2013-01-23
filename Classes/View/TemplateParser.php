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

	protected $startRegexp = '/(\{[\{\[\<])/';

	protected $endRegexp = '/([\>\]\}]\})/';

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
		var_dump($this->toDisplay);

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

		$this->htmlString = trim($this->htmlString);

		$this->generateStartAndEndParts();
		// todo: parse!

		$this->removeTemplateComments();

		$this->generateEchoForTextParts();

		$this->parseObjects();

		$this->parsePhpFunctions();

		$this->phpString .= $this->htmlString;
	}

	protected function generateStartAndEndParts() {
		if (preg_match('/^(\{[\{\[\<])/', $this->htmlString) === 0) {
			$this->htmlString = 'echo \''.$this->htmlString;
		}

		if (preg_match('/([\>\]\}]\})$/', $this->htmlString) === 0) {
			$this->htmlString = $this->htmlString."';\n";
		}
	}

	protected function generateEchoForTextParts() {
		$this->htmlString = preg_replace($this->startRegexp, '\';
${1}', $this->htmlString);

		$this->htmlString = preg_replace($this->endRegexp, '${1}
echo \'', $this->htmlString);
	}

	protected function removeTemplateComments() {
		$this->htmlString = preg_replace('/{<.*>}/', '', $this->htmlString);
	}

	/**
	 * parse {{}}-strings and use the next method to get the proper echo string
	 */
	protected function parseObjects() {
		$this->htmlString = preg_replace_callback('/\{\{(.+)\}\}/', array($this, 'splitObjectAtDotAndEcho'), $this->htmlString);
	}

	/**
	 * Builds the string echo $array['object']->getProperty()->getSubproperty();
	 * for {{object.property.subproperty}}
	 *
	 * @param $matches
	 * @return string
	 */
	protected function splitObjectAtDotAndEcho($matches) {

		$fullText = 'echo ';

		$fullText .= $this->splitObjectAtDot($matches[1]);

		$fullText .= ';';
		return $fullText;
	}

	/**
	 * Builds the string $array['object']->getProperty()->getSubproperty()
	 * for object.property.subproperty
	 *
	 * @param $matches
	 * @return string
	 */
	protected function splitObjectAtDot($matches) {
		$splittedText = explode('.', $matches);

		$fullText = '$this->toDisplay[\''.$splittedText[0].'\']';

		if (count($splittedText) > 1) {
			unset($splittedText[0]);

			foreach ($splittedText as $textSnippet) {
				$fullText .= '->get'.ucfirst($textSnippet).'()';
			}
		}

		return $fullText;
	}

	/**
	 * Wrapper for the parsing og {[]} strings to their respective php function, use the next method as callback
	 */
	protected function parsePhpFunctions() {
		$this->htmlString = preg_replace_callback('/\{\[(.+)\]\}/', array($this, 'breakUpFunctionStringAndParse'), $this->htmlString);
	}

	/**
	 * gets the php function name to parse and calls the respective parser function
	 *
	 * @param $matches
	 * @return mixed
	 */
	protected function breakUpFunctionStringAndParse($matches) {
		$parts = explode(' ', $matches[1]);
		$functionName = $parts[0];
		$parseFunctionName = 'parseFunction'.ucfirst($functionName);
		return $this->$parseFunctionName($parts);
	}

	/**
	 * Parse foreach-functions
	 *
	 * @param $parts
	 * @return string
	 */
	protected function parseFunctionForeach($parts) {
		foreach ($parts as &$singlePart) {
			var_dump($singlePart);
			if (preg_match('/\{(.+)\}/', $singlePart)) {
				$singlePart = preg_replace('/\{(.+)\}/', '${1}', $singlePart);
				$singlePart = $this->splitObjectAtDot($singlePart);
			}
		}

		$forString = 'foreach ('.$parts[1].' '.$parts[2].' '.$parts[3].') {';
		return $forString;
	}

	/**
	 * parse if-functions
	 *
	 * @param $parts
	 * @return string
	 */
	protected function parseFunctionIf($parts) {
		foreach ($parts as &$singlePart) {
			var_dump($singlePart);
			if (preg_match('/\{(.+)\}/', $singlePart)) {
				$singlePart = preg_replace('/\{(.+)\}/', '${1}', $singlePart);
				$singlePart = $this->splitObjectAtDot($singlePart);
			}
		}
		$ifString = 'if ('.$parts[1];

		if (count($parts > 2)) {
			if ((strncmp($parts[3], '$', 1) !== 0) && (!is_numeric($parts[3]))) {
				$parts[3] = '\''.$parts[3]. '\'';
			}
			$ifString .= ' '.$parts[2].' '.$parts[3];
		}

		$ifString .= ') {';
		return $ifString;
	}

	/**
	 * 'parse' end-parts - returns a closing bracket
	 *
	 * @param $parts
	 * @return string
	 */
	protected function parseFunctionEnd($parts) {
		return '}';
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
	protected function writePhpStringToCacheFile() {
		$fileHandle = fopen($this->pathToCacheFile, 'w+');

		fwrite($fileHandle, $this->phpString);

		fclose($fileHandle);
	}

	/**
	 * if any parser is called which isn't available, just return an empty string so that
	 * the file won't break
	 *
	 * @param $name
	 * @param $params
	 * @return string
	 */
	public function __call($name, $params) {
		return '';
	}

}

?>