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

namespace Kabarakh\Mirarse\Bootstrap;

/**
 * This class is the class autoloader for the whole gallery. It expects classes in the namespace
 * Kabarakh\Mirarse and the files in /Classes/ with the file extension .php
 */
class Autoloader {

	/**
	 * Initializes and registers the autoload method
	 *
	 * @return void
	 */
	public function init() {
		spl_autoload_register(__NAMESPACE__.'\Autoloader::autoload');
		spl_autoload_register(__NAMESPACE__.'\Autoloader::autoloadForeign');
	}

	/**
	 * Autoloader for classes.
	 * Assumes that all classes
	 *
	 * @param $className
	 * @throws \Exception
	 */
	public static function autoload($className) {

		$rootNameSpace = 'Kabarakh\\Mirarse\\';

		$filename = str_replace($rootNameSpace, GALLERY_CLASSES, $className).".php";
		$filename = str_replace('\\', '/', $filename);

		if (file_exists($filename)) {
			include_once($filename);
		}
	}

	public static function autoloadForeign($className) {

		$foreignLibraryPath = GALLERY_ROOT_PATH.'ForeignLibraries/';

		$filename = str_replace('\\', '/', $className);
		$filename = $foreignLibraryPath.$filename.'.php';

		if (file_exists($filename)) {
			include_once($filename);
		}
	}
}
?>