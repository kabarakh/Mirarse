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
namespace Kabarakh\Mirarse\View\ViewFunctions;

class CallActionViewFunction extends \Kabarakh\Mirarse\View\ViewFunctions\AbstractViewFunction {

	/**
	 * @var \Kabarakh\Mirarse\FileSystemHandler\YamlParser
	 * @inject
	 */
	protected $yamlParser;

	public function render() {
		$controller = ucfirst($this->controller);
		$action = strtolower($this->action);

		$href = $this->href ? $this->href : '.';

		unset($this->properties['controller']);
		unset($this->properties['action']);
		unset($this->properties['href']);

		foreach ($this->properties as $name => &$singleProperty) {
			if (preg_match('/^\{[^{\}]+\}$/', $singleProperty)) {
				$singleProperty = '".'.$this->objectParser->parseObjectStringToPhpForm($singleProperty).'."';
			}
		}

		$propertiesYaml = trim($this->yamlParser->arrayToYaml($this->properties, 0, 0));

		$parameterSting = '?Mirarse%5Bcontroller%5D='.$controller.'&Mirarse%5Baction%5D='.$action.'&Mirarse%5Bparameter%5D=".urlencode("'.$propertiesYaml.'")';

		$completeLink = 'echo "'.$href . $parameterSting;

		return $completeLink;
	}

	public function validateParameter() {
		if (!$this->controller || !$this->action) {
			throw new \Exception('The parameters controller and action must be given in callActionViewFunction', 1371245140);
		}
	}


}
?>