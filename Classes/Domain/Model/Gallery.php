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

namespace Kabarakh\Mirarse\Domain\Model;

/**
 * The model for a gallery
 */
class Gallery extends \Kabarakh\Mirarse\Domain\Model\AbstractModel {

	/**
	 * @var string
	 */
	protected $path;

	/**
	 * @var integer
	 */
	protected $numberOfImages;

	/**
	 * @var array
	 */
	protected $images;

	/**
	 * @var \Kabarakh\Mirarse\Domain\Model\SingleGalleryConfig
	 */
	protected $galleryConfig;

	/**
	 * @param \Kabarakh\Mirarse\Domain\Model\SingleGalleryConfig $galleryConfig
	 */
	public function setGalleryConfig($galleryConfig) {
		$this->galleryConfig = $galleryConfig;
	}

	/**
	 * @return \Kabarakh\Mirarse\Domain\Model\SingleGalleryConfig
	 */
	public function getGalleryConfig() {
		return $this->galleryConfig;
	}

	/**
	 * @param $images array
	 */
	public function setImages($images) {
		$this->images = $images;
	}

	/**
	 * @return array
	 */
	public function getImages() {
		return $this->images;
	}

	/**
	 * @param integer $numberOfImages
	 */
	public function setNumberOfImages($numberOfImages) {
		$this->numberOfImages = $numberOfImages;
	}

	/**
	 * @return integer
	 */
	public function getNumberOfImages() {
		return $this->numberOfImages;
	}

	/**
	 * @param string $path
	 */
	public function setPath($path) {
		$this->path = $path;
	}

	/**
	 * @return string
	 */
	public function getPath() {
		return $this->path;
	}

}

?>