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

class DebugViewFunction extends \Kabarakh\Mirarse\View\ViewFunctions\AbstractViewFunction {


	public function render() {
		return 'echo nl2br(var_export('.$this->objectParser->parseObjectStringToPhpForm($this->object).", TRUE));\n";
	}

	public function validateParameter() {
		if (!$this->object) {
			throw new \Exception('The parameter object must be given for debugRenderFunction', 1372109944);
		}
	}

}
?>