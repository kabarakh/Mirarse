<?php

namespace Kaba\Gallery\Controller;

/**
 * The view class for controllers.
 *
 * @method render
 */
class ControllerView {

	/**
	 * Magic function to do anything...
	 *
	 * @param $functionName
	 * @param $arguments
	 */
	public function __call($functionName, $arguments) {
		echo "Doing function ".$functionName."\n";
	}
}