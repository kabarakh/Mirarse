<?php

namespace Kaba\Gallery\Bootstrap;

/**
 * This class is the class autoloader for the whole gallery. It expects classes in the namespace
 * Kaba\Gallery and the files in /Classes/ with the file extension .php
 */
class Autoloader {

	/**
	 * Initializes and registers the autoload method
	 *
	 * @return void
	 */
	public function init() {
		echo "Initializing autoloader\n";
		spl_autoload_register(__NAMESPACE__.'\Autoloader::autoload');
	}

	public static function autoload($className) {
		echo "Class to load: ".$className."\n";

		$filename = str_replace('Kaba\\Gallery\\', GALLERY_CLASSES, $className).".php";
		$filename = str_replace('\\', '/', $filename);

		echo "File to load: ".$filename."\n";
		if (file_exists($filename)) {
			include_once($filename);
		} else {
			throw new \Exception('File '.$filename.' for class '.$className.' not found', 1357343576);
		}
	}
}
?>