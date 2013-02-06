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
 * The model for the images which are in one gallery
 */
class Image extends \Kabarakh\Mirarse\Domain\Model\AbstractModel {

	/**
	 * @var string
	 */
	protected $path;

	/**
	 * @var boolean
	 */
	protected $hasThumbnail;

	/**
	 * @var string
	 */
	protected $thumbnailLocation;

	/**
	 * @var integer
	 */
	protected $originalHeight;

	/**
	 * @var integer
	 */
	protected $originalWidth;

	/**
	 * @var integer
	 */
	protected $calculatedHeight;

	/**
	 * @var integer
	 */
	protected $calculatedWidth;

	/**
	 * @var string
	 */
	protected $nextImagePath;

	/**
	 * @var string
	 */
	protected $previousImagePath;

	/**
	 * @var string
	 */
	protected $galleryPath;

	/**
	 * @param string $galleryPath
	 */
	public function setGalleryPath($galleryPath) {
		$this->galleryPath = $galleryPath;
	}

	/**
	 * @return string
	 */
	public function getGalleryPath() {
		return $this->galleryPath;
	}

	/**
	 * @param boolean $hasThumbnail
	 */
	public function setHasThumbnail($hasThumbnail) {
		$this->hasThumbnail = $hasThumbnail;
	}

	/**
	 * @return boolean
	 */
	public function getHasThumbnail() {
		return $this->hasThumbnail;
	}

	/**
	 * @param string $thumbnailLocation
	 */
	public function setThumbnailLocation($thumbnailLocation) {
		$this->thumbnailLocation = $thumbnailLocation;
	}

	/**
	 * @return string
	 */
	public function getThumbnailLocation() {
		if ($this->hasThumbnail) {
			return $this->thumbnailLocation;
		} else {
			return '';
		}
	}

	/**
	 * @param string $nextImagePath
	 */
	public function setNextImagePath($nextImagePath) {
		$this->nextImagePath = $nextImagePath;
	}

	/**
	 * @return string
	 */
	public function getNextImagePath() {
		return $this->nextImagePath;
	}

	/**
	 * @param integer $originalHeight
	 */
	public function setOriginalHeight($originalHeight) {
		$this->originalHeight = $originalHeight;
	}

	/**
	 * @return integer
	 */
	public function getOriginalHeight() {
		return $this->originalHeight;
	}

	/**
	 * @param integer $originalWidth
	 */
	public function setOriginalWidth($originalWidth) {
		$this->originalWidth = $originalWidth;
	}

	/**
	 * @return integer
	 */
	public function getOriginalWidth() {
		return $this->originalWidth;
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

	/**
	 * @param string $previousImagePath
	 */
	public function setPreviousImagePath($previousImagePath) {
		$this->previousImagePath = $previousImagePath;
	}

	/**
	 * @return string
	 */
	public function getPreviousImagePath() {
		return $this->previousImagePath;
	}

	/**
	 * @param int $calculatedHeight
	 */
	public function setCalculatedHeight($calculatedHeight) {
		$this->calculatedHeight = $calculatedHeight;
	}

	/**
	 * @return int
	 */
	public function getCalculatedHeight() {
		return $this->calculatedHeight;
	}

	/**
	 * @param int $calculatedWidth
	 */
	public function setCalculatedWidth($calculatedWidth) {
		$this->calculatedWidth = $calculatedWidth;
	}

	/**
	 * @return int
	 */
	public function getCalculatedWidth() {
		return $this->calculatedWidth;
	}

}
?>