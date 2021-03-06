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
 * Domain Model for the configuration of galleries, created out of the config files
 */
class SingleGalleryConfig extends \Kabarakh\Mirarse\Domain\Model\AbstractModel {

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @var string
	 */
	protected $description;

	/**
	 * @var \DateTime
	 */
	protected $date;

	/**
	 * @var integer
	 */
	protected $imageSize;

	/**
	 * @var string
	 */
	protected $thumbnailsPrefix;

	/**
	 * @var string
	 */
	protected $thumbnailsLocation;

	/**
	 * @var string
	 */
	protected $galleryThumbnail;

	/**
	 * @param \DateTime $date
	 */
	public function setDate($date) {
		$this->date = $date;
	}

	/**
	 * @return \DateTime
	 */
	public function getDate() {
		return $this->date;
	}

	/**
	 * @param string $description
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @param string $thumbnailsLocation
	 */
	public function setThumbnailsLocation($thumbnailsLocation) {
		$this->thumbnailsLocation = $thumbnailsLocation;
	}

	/**
	 * @return string
	 */
	public function getThumbnailsLocation() {
		return $this->thumbnailsLocation;
	}

	/**
	 * @param string $thumbnailsPrefix
	 */
	public function setThumbnailsPrefix($thumbnailsPrefix) {
		$this->thumbnailsPrefix = $thumbnailsPrefix;
	}

	/**
	 * @return string
	 */
	public function getThumbnailsPrefix() {
		return $this->thumbnailsPrefix;
	}

	/**
	 * @param string $title
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @param int $imageSize
	 */
	public function setImageSize($imageSize) {
		$this->imageSize = $imageSize;
	}

	/**
	 * @return int
	 */
	public function getImageSize() {
		return $this->imageSize;
	}

	/**
	 * @param string $galleryThumbnail
	 */
	public function setGalleryThumbnail($galleryThumbnail) {
		$this->galleryThumbnail = $galleryThumbnail;
	}

	/**
	 * @return string
	 */
	public function getGalleryThumbnail() {
		return $this->galleryThumbnail;
	}

}

?>