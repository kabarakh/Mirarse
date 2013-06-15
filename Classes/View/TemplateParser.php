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
	 * @var \Kabarakh\Mirarse\View\ObjectParser
	 * @inject
	 */
	protected $objectParser;

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
	 * @var array
	 */
	protected $parseArray = array();

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

		$this->htmlString = trim($this->htmlString);

		$this->spitHtmlStringToGetParseArray();

		$this->determineTypeOfAllParts();

		// todo: for each part to the appropriate thing
		$this->parseEachArrayPartByType();

		// todo: after parsing the array implode with \n should be all to generate the php string
		$this->concatenateParseArrayParts();
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

	}

	/**
	 * write the php-string to the proper file
	 */
	protected function writePhpStringToCacheFile() {
		$fileHandle = fopen($this->pathToCacheFile, 'w+');

		fwrite($fileHandle, $this->phpString);

		fclose($fileHandle);
	}

	public function __call($name, $params) {
		throw new \Exception('Function with name '.$name. ' not defined', 1371059373);
	}

	protected function spitHtmlStringToGetParseArray() {
		$this->parseArray = preg_split('/(\{[\{\[\<]|[\>\]\}]\})/', $this->htmlString, NULL, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
	}

	protected function determineTypeOfAllParts() {
		foreach ($this->parseArray as $key => $parseArrayEntry) {
			if (preg_match('/([\>\]\}]\})/', $parseArrayEntry)) {
				unset($this->parseArray[$key]);
			} elseif (preg_match('/(\{[\{\[\<])/', $parseArrayEntry)) {
				unset($this->parseArray[$key]);
				$this->setTypeForArrayEntry($parseArrayEntry, ($key + 1));
			} else {
			}
		}
		$this->setInlineTypeToStringEntries();
	}

	protected function parseEachArrayPartByType() {
		foreach ($this->parseArray as &$parseArrayEntry) {
			$parseArrayEntry = $this->parseArrayEntryByType($parseArrayEntry);
		}
	}

	protected function parseArrayEntryByType($arrayEntry) {
		if ($arrayEntry['type'] === 'inline') {
			$arrayEntry['value'] = 'echo "'. addslashes($arrayEntry['value']) .'"';
		} elseif ($arrayEntry['type'] === 'property') {
			$arrayEntry['value'] = 'echo '.$this->objectParser->parseObjectStringToPhpForm($arrayEntry['value']);
		} elseif ($arrayEntry['type'] === 'comment') {
			unset($arrayEntry);
		} elseif ($arrayEntry['type'] === 'function') {
			$arrayEntry['value'] = $this->determineAndCallRenderFunction($arrayEntry['value']);
		} else {
			throw new \Exception('Wrong type for parse array entry. This should never happen', 1371072952);
		}

		return $arrayEntry;
	}

	protected function setTypeForArrayEntry($parseArrayEntry, $key) {
		switch ($parseArrayEntry) {
			case '{{':
				$parseArrayEntry = array(
					'type' => 'property',
					'value' => $this->parseArray[$key],
				);
				break;
			case '{[':
				$parseArrayEntry = array(
					'type' => 'function',
					'value' => $this->parseArray[$key],
				);
				break;
			case '{<':
				$parseArrayEntry = array(
					'type' => 'comment',
					'value' => $this->parseArray[$key],
				);
				break;
			default:
				throw new \Exception('Wrong string to determine type. This should never happen', 1371160341);
		}
		$this->parseArray[$key] = $parseArrayEntry;
	}

	protected function setInlineTypeToStringEntries() {
		foreach ($this->parseArray as $key => $parseArrayEntry) {
			if (gettype($parseArrayEntry) === 'string') {
				$this->parseArray[$key] = array(
					'type' => 'inline',
					'value' => $parseArrayEntry
				);
			}
		}
	}

	/**
	 * @param string $stringToRender
	 *
	 * @return string
	 * @throws \Exception
	 */
	protected function determineAndCallRenderFunction($stringToRender) {
		$splittedFunctionEntry = explode(' ', $stringToRender);
		$className = 'Kabarakh\\Mirarse\\View\\ViewFunctions\\' . ucfirst($splittedFunctionEntry[0]) . 'ViewFunction';
		unset($splittedFunctionEntry[0]);

		if (class_exists($className)) {
			/** @var \Kabarakh\Mirarse\View\ViewFunctions\AbstractViewFunction $viewFunctionClass */
			$viewFunctionClass = new $className($splittedFunctionEntry);

			$viewFunctionClass->validateParameter();

			return $viewFunctionClass->render();

		} else {
			throw new \Exception('ViewFunction ' . $className . ' not found', 1371075969);
		}
	}

	protected function concatenateParseArrayParts() {
		foreach ($this->parseArray as $arrayPart) {
			$this->phpString .= $arrayPart['value'].';';
		}
	}

}

?>