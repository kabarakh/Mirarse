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
 * Initialize the whole stuff. Directories/Paths, Class autoloader, whatever comes in my mind...
 * Maybe include some config stuff here
 */
class Initializer {

	/**
	 * The main initialize method. Calls all the other init-methods
	 *
	 * @return void
	 */
	public function init() {

		$this->initDirectories();

		$this->initAutoloader();

		date_default_timezone_set('Europe/Berlin');

	}

	/**
	 * Define class paths, template paths, maybe config paths
	 *
	 * @return void
	 */
	protected function initDirectories() {
		if (isset($_ENV['DOCUMENT_ROOT'])) {
			define('MIRARSE_SERVER_ROOT', $_ENV['DOCUMENT_ROOT']);
		} else {
			// server root to build absolute paths in frontend
			define('MIRARSE_SERVER_ROOT', $_SERVER['DOCUMENT_ROOT']);
		}

		// with this we define the SCRIPT_ROOT_PATH to the location of this very file, no matter from where it is included
		define('MIRARSE_ROOT_PATH', realpath(dirname(__FILE__).'/../../').'/');

		// get the path from where the gallery is run so we can use the relative path from there for gallery locations
		define('MIRARSE_RUN_DIRECTORY', realpath('.').'/');

		define('MIRARSE_TESTS', MIRARSE_ROOT_PATH.'Tests/');

		define('MIRARSE_RESOURCES', MIRARSE_ROOT_PATH.'Resources/');

		define('MIRARSE_TEMPLATES', MIRARSE_RESOURCES.'Templates/');
		define('MIRARSE_LAYOUTS', MIRARSE_RESOURCES.'Layouts/');
		define('MIRARSE_PARTIALS', MIRARSE_RESOURCES.'Partials/');

		define('MIRARSE_CACHE', MIRARSE_RUN_DIRECTORY.'Cache/');

		define('CLASS_CACHE_DIR', MIRARSE_CACHE);

	}

	/**
	 * Initializes the class autoloader
	 *
	 * @return void
	 */
	protected function initAutoloader() {
		require_once(__DIR__ . '/../../vendor/autoload.php');
	}

}
?>