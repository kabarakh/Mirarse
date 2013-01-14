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

namespace Kabarakh\Mirarse\ClassMagic;

/**
 * A base class for all other classes in the gallery - only thing to achieve with that are global __construct
 * and __toString methods so we can always inject stuff and use class names when echo'ing objects
 */
abstract class GalleryBaseClass {

	/**
	 * Global constructor for every class. should be called always, must be called if you want to use injects
	 */
	public function __construct() {
		$classMagic = new \Kabarakh\Mirarse\ClassMagic\ClassMagic();
		$classMagic->resolveInjects($this);
	}

	/**
	 * if an object is echo'ed this just echos the class name of the object
	 *
	 * @return string
	 */
	public function __toString() {
		return get_class($this);
	}
}

?>