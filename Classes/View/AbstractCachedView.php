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
namespace Kabarakh\Mirarse\View;

/**
 * The class which the cache-files get
 */
abstract class AbstractCachedView extends \Kabarakh\Mirarse\ClassMagic\GalleryBaseClass {

	/**
	 * the toDisplay-Array from the controllerView. Needed here to get all the variables into the html
	 *
	 * @var array
	 */
	protected $toDisplay;

	/**
	 * the method which is run to render the cache file
	 *
	 * @return mixed
	 */
	abstract function renderCached();

}

?>