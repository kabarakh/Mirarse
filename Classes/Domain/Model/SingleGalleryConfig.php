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

use Kabarakh\Mirarse\Domain\Model\PropertySanitizer as Sanitizer;

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
	 * @var string
	 */
	protected $thumbnailsPrefix;

	/**
	 * @var string
	 */
	protected $thumbnailsLocation;

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
	 * Creates a SingleGalleryConfigFile from an array
	 *
	 * @param array $configFileArray
	 * @return null|\Kabarakh\Mirarse\Domain\Model\SingleGalleryConfig
	 */
	static public function createConfigObjectFromConfigFileContent(array $configFileArray) {
		if (Sanitizer\dateTimeSanitizer::validateDate($configFileArray['date'])) {
			$configFileArray['date'] = new \DateTime($configFileArray['date'], new \DateTimeZone('Europe/Berlin'));
		}

		foreach ($configFileArray['thumbnails'] as $key => $thumbnailOption) {
			$configFileArray['thumbnails'.ucfirst($key)] = $thumbnailOption;
			unset($configFileArray[$key]);
		}
		unset($configFileArray['thumbnails']);

		$galleryConfigObject = self::getObjectFromArray($configFileArray);

		return $galleryConfigObject;
	}

}

?>