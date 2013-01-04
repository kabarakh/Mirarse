<?php

namespace Kaba\Gallery\Bootstrap;

/**
 * This class is the class autoloader for the whole gallery. It expects classes in the namespace
 * Kaba\Gallery and the files in /Classes/ with the file extension .php
 */
class Autoloader {
    
    /**
     * Inits and registers the autoload method
     * @return void
     */
    public function init() {
        echo "Initializing autoloader\n";
        spl_autoload_register(__NAMESPACE__.'\Autoloader::autoload');
    }
    
    /**
     * The autoloader itself. 
     * @param String $classname The class to load, expected is the namespace Kaba\Gallery
     * @return void
     */
    public static function autoload($classname) {
        echo "Class to load: ".$classname."\n";
        
        $filename = str_replace('Kaba\\Gallery\\', GALLERY_CLASSES, $classname).".php";
        $filename = str_replace('\\', '/', $filename);
        
        echo "File to load: ".$filename."\n";
        include_once($filename);
    }
}
?>