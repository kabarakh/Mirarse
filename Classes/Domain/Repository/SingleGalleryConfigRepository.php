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
namespace Kabarakh\Mirarse\Domain\Repository;

/**
 * Repository for the singleGalleryConfig domain objects
 */
class SingleGalleryConfigRepository extends \Kabarakh\Mirarse\Domain\Repository\AbstractRepository {

	/**
	 * @var \Kabarakh\Mirarse\Domain\Model\ModelProvider
	 * @inject
	 */
	protected $modelProvider;

	/**
	 * @var \Kabarakh\Mirarse\Domain\Model\PropertySanitizer\DateTimeSanitizer
	 * @inject
	 */
	protected $dateTimeSanitizer;

	/**
	 * @var \Kabarakh\Mirarse\FileSystemHandler\FolderHandler
	 * @inject
	 */
	protected $folderHandler;

	/**
	 * Generates a singleGalleryConfigObject for a folder with $path
	 *
	 * @param $path
	 * @return \Kabarakh\Mirarse\Domain\Model\SingleGalleryConfig|null
	 */
	public function generateSingleGalleryConfigFromPath($path) {
		$configFileContent = $this->folderHandler->getConfigFileFromFolder($path);

		$singleGalleryConfig = $this->createConfigObjectFromConfigFileContent($configFileContent);

		return $singleGalleryConfig;
	}

	/**
	 * Creates a SingleGalleryConfigFile from an array
	 *
	 * @param array $configFileArray
	 * @return null|\Kabarakh\Mirarse\Domain\Model\SingleGalleryConfig
	 */
	protected function createConfigObjectFromConfigFileContent(array $configFileArray) {
		$date = date('Y-m-d', $configFileArray['date']);

		if ($this->dateTimeSanitizer->validateDate($date)) {
			$configFileArray['date'] = new \DateTime($date);
		}

		$imageSize = 0;

		if ($GLOBALS['parameter']['imageSize']) {
			$imageSize = $GLOBALS['parameter']['imageSize'];
		}

		if ($configFileArray['imageSize']) {
			$imageSize = $configFileArray['imageSize'];
		}

		$configFileArray['imageSize'] = $imageSize;

		if (!$configFileArray['galleryThumbnail']) {
			$configFileArray['galleryThumbnail'] = '';
		}

		foreach ($configFileArray['thumbnails'] as $key => $thumbnailOption) {
			$configFileArray['thumbnails'.ucfirst($key)] = $thumbnailOption;
			unset($configFileArray[$key]);
		}
		unset($configFileArray['thumbnails']);

		$galleryConfigObject = $this->modelProvider->getObjectFromArray('\Kabarakh\Mirarse\Domain\Model\SingleGalleryConfig', $configFileArray);

		return $galleryConfigObject;
	}

}

?>