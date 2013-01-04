<?php

namespace Kaba;

/**
 * The main class for the gallery. Starts the whole thing and contains the controllers
 */
class Gallery {
    
    /**
     * Starts the gallery. After calling this method you have access to the controllers
     * @return void
     */
    public function main() {
        // with this we define the SCRIPT_ROOT_PATH to the location of this very file, no matter from where it is included
        define(SCRIPT_ROOT_PATH, dirname(__FILE__).'/');
        
        // get the bootstrap and initialitze everything
        require_once SCRIPT_ROOT_PATH."Classes/Bootstrap/Initializer.php";
        
        $bootstrap = new Gallery\Bootstrap\Initializer();
        $bootstrap->init();
        
        // test for autoloader
        $gallery = new Gallery\Controller\Gallery();
        
        $gallery->callAction('list', array('directory' => '/var/www/'));
    }
}
?>