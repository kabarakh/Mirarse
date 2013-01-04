<?php

namespace Kaba\Gallery\Controller;

class ControllerView {
    public function __call($functionName, $arguments) {
        echo "Doing function ".$functionName."\n";
    }
}