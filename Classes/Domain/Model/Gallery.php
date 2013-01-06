<?php

namespace Kaba\Gallery\Domain\Model;

/**
 *
 */
class Gallery {

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