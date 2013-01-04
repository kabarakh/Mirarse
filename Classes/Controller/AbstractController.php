<?php

namespace Kaba\Gallery\Controller;

class AbstractController {
    
    /**
     * @var \Kaba\Gallery\Controller\ControllerView
     */
    protected $view;
    
    public function __construct() {
        $this->view = new \Kaba\Gallery\Controller\ControllerView();
    }
    
    public function callAction($actionName, $parameter, $controller = NULL) {
        $action = $actionName."Action";
        
        echo "Called class: ".get_called_class(). "\n";
        echo "Action: ".$action."\n";
        echo "Parameters: ".print_r($parameter, TRUE);
        
        echo "Calling ".get_called_class().'->'.$action."\n";
        
        try {
            if ($controller != NULL) {
                $controllerClassName = __NAMESPACE__."\\".$controller;
                
                if (!class_exists($controllerClassName)) {
                    throw new \Exception('Class not found: '.$controllerClassName, 1357259410);
                }
                
                $controllerObject = new $controllerClassName();
            } else {
                $controllerObject = clone $this;
            }
            
            $controllerObject->$action();
        } catch (\Exception $e) {
            die("Error: ".$e);
        }
        
        $this->view->render();
    }
}

?>