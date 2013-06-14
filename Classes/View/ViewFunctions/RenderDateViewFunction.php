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

class RenderDateViewFunction extends \Kabarakh\Mirarse\View\ViewFunctions\AbstractViewFunction {

	public function render() {
		$objectName = '';

		if ($this->string) {

				try {
				$objectName = 'date_create("'.$this->string.'")';
			} catch (\Exception $e) {
				throw new \Exception('Date format not working for displaying the date', 1371230207);
			}

		} elseif ($this->object) {
			$objectName = $this->objectParser->parseObjectStringToPhpForm($this->object);
		}

		$format = $this->format ? $this->format : 'Y/m/d';

		return 'echo '.$objectName. '->format("' .$format .'")';
	}

	public function validateParameter() {
		if (!$this->string && !$this->object) {
			throw new \Exception('Either object or string has to be given as a parameter in renderDate renderFunction', 1371163180);
		}
	}

}
?>