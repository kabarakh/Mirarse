<?php

namespace Kaba\Gallery\Bootstrap;

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

	}

	/**
	 * Define class paths, template paths, maybe config paths
	 *
	 * @return void
	 */
	protected function initDirectories() {

		// with this we define the SCRIPT_ROOT_PATH to the location of this very file, no matter from where it is included
		define('GALLERY_ROOT_PATH', realpath(dirname(__FILE__).'/../../').'/');

		// get the path from where the gallery is run so we can use the relative path from there for gallery locations
		define('GALLERY_RUN_DIRECTORY', realpath('.').'/');

		echo "Script-Run-Directory: ".GALLERY_RUN_DIRECTORY."\n";

		echo "Script-Main-Directory: ".GALLERY_ROOT_PATH."\n";

		define('GALLERY_CLASSES', GALLERY_ROOT_PATH.'Classes/');

		define('GALLERY_VIEWS', GALLERY_ROOT_PATH.'View/');

		echo "Gallery Classes: ". GALLERY_CLASSES."\n";
		echo "Gallery Views: ". GALLERY_VIEWS."\n";
	}

	/**
	 * Initializes the class autoloader
	 *
	 * @return void
	 */
	protected function initAutoloader() {

		require_once(GALLERY_CLASSES.'Bootstrap/Autoloader.php');

		$autoloader = new Autoloader();
		$autoloader->init();
	}

}
?>