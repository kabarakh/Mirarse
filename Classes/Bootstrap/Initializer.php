<?php

namespace Kaba\Gallery\Bootstrap;

/**
 * Initialize the whole stuff. Directories/Paths, Class autoloader, whatever comes in my mind...
 * Maybe include some config stuff here
 */
class Initializer {
    
    /**
     * The main initialize method. Calls all the other init-methods
     * @return void
     */
    public function init() {
        
        echo "Script-Main-Directory: ".SCRIPT_ROOT_PATH."\n";
        
        $this->initDirectories();
        
        $this->initAutoloader();
        
    }
    
    /**
     * Define class paths, template paths, maybe config paths
     * @return void
     */
    protected function initDirectories() {
        
        define(GALLERY_CLASSES, SCRIPT_ROOT_PATH.'Classes/');
        
        define(GALLERY_VIEWS, SCRIPT_ROOT_PATH.'View/');
        
        echo "Gallery Classes: ". GALLERY_CLASSES."\n";
        echo "Gallery Views: ". GALLERY_VIEWS."\n";
    }
    
    /**
     * Initializes the class autoloader
     * @return void
     */
    protected function initAutoloader() {
        
        require_once(GALLERY_CLASSES.'Bootstrap/Autoloader.php');
        
        $autoloader = new Autoloader();
        $autoloader->init();
    }
    
}
?>