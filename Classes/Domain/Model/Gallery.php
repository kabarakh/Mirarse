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

namespace Kaba\Gallery\Domain\Model;

/**
 * The model for a gallery
 */
class Gallery extends \Kaba\Gallery\Domain\Model\AbstractModel {

	/**
	 * @var String
	 */
	protected $path;

	/**
	 * @var int
	 */
	protected $numberOfImages;

	/**
	 * @var String
	 */
	protected $title;

	/**
	 * @var \DateTime
	 */
	protected $date;

	/**
	 * @var String
	 */
	protected $description;

	/**
	 * @var Image[]
	 */
	protected $images;

	/**
	 * @var String
	 */
	protected $galleryThumbnail;

	/**
	 * @param $date
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
	 * @param $description
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * @return String
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @param $images
	 */
	public function setImages($images) {
		$this->images = $images;
	}

	/**
	 * @return Image[]
	 */
	public function getImages() {
		return $this->images;
	}

	/**
	 * @param $numberOfImages
	 */
	public function setNumberOfImages($numberOfImages) {
		$this->numberOfImages = $numberOfImages;
	}

	/**
	 * @return int
	 */
	public function getNumberOfImages() {
		return $this->numberOfImages;
	}

	/**
	 * @param $path
	 */
	public function setPath($path) {
		$this->path = $path;
	}

	/**
	 * @return String
	 */
	public function getPath() {
		return $this->path;
	}

	/**
	 * @param $title
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * @return String
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @param String $galleryThumbnail
	 */
	public function setGalleryThumbnail($galleryThumbnail) {
		$this->galleryThumbnail = $galleryThumbnail;
	}

	/**
	 * @return String
	 */
	public function getGalleryThumbnail() {
		return $this->galleryThumbnail;
	}

}

?>