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
 * Repository for the image domain objects
 */
class ImageRepository extends \Kabarakh\Mirarse\Domain\Repository\AbstractRepository {

	/**
	 * @var \Kabarakh\Mirarse\FileSystemHandler\Validator\FileValidator
	 * @inject
	 */
	protected $fileValidator;

	/**
	 * @var \Kabarakh\Mirarse\FileSystemHandler\Validator\FolderValidator
	 * @inject
	 */
	protected $folderValidator;

	/**
	 * @var \Kabarakh\Mirarse\FileSystemHandler\FolderHandler
	 * @inject
	 */
	protected $folderHandler;


	/**
	 * @param $path string
	 * @param $singleGalleryConfig \Kabarakh\Mirarse\Domain\Model\SingleGalleryConfig
	 *
	 * @return \Kabarakh\Mirarse\Domain\Model\Image
	 */
	public function generateImageFromPathWithSingleGalleryConfig($path, $singleGalleryConfig) {
		if (!$this->fileValidator->validateFileExists($path)) {
			return NULL;
		}

		$galleryPath = dirname($path);

		$fullPathToThumbnailLocation = $galleryPath.'/'.$singleGalleryConfig->getThumbnailsLocation();

		if (!$this->folderValidator->validateFolderExists($fullPathToThumbnailLocation)) {
			$this->folderHandler->generateFolderPath($fullPathToThumbnailLocation);
		}

		$fullPathToThumbnail = $fullPathToThumbnailLocation.'/'.$singleGalleryConfig->getThumbnailsPrefix().basename($path);

		$hasThumbnail = FALSE;
		if ($this->fileValidator->validateFileExists($fullPathToThumbnail)) {
			$hasThumbnail = TRUE;
		}

		$imageData = getimagesize($path);
		$originalHeight = $imageData[1];
		$originalWidth = $imageData[0];

		$calculatedHeight = $originalHeight;
		$calculatedWidth = $originalWidth;

		if ($singleGalleryConfig->getImageSize() !== 0) {
			if ($originalHeight > $originalWidth) {
				$calculatedHeight = (int)($singleGalleryConfig->getImageSize());
				$calculatedWidth = (int)($calculatedHeight*$originalWidth/$originalHeight);
			} else {
				$calculatedWidth = (int)($singleGalleryConfig->getImageSize());
				$calculatedHeight = (int)($calculatedWidth*$originalHeight/$originalWidth);
			}
		}

		$galleryFiles = $this->folderHandler->getContentsOfFolder($galleryPath);
		$galleryFiles->limitResultToImages();
		$position = array_search($path, $galleryFiles->getContent());

		$nextImagePath = '';
		$previousImagePath = '';

		if (!$position === 0) {
			$previousImagePath = $galleryPath[($position-1)];
		}
		if (!$position === (count($galleryPath)-1)) {
			$nextImagePath = $galleryPath[($position+1)];
		}

		$imageObjectArray = array (
			'path' => $path,
			'galleryPath' => $galleryPath,
			'hasThumbnail' => $hasThumbnail,
			'thumbnailLocation' => $fullPathToThumbnail,
			'originalHeight' => $originalHeight,
			'originalWidth' => $originalWidth,
			'calculatedHeight' => $calculatedHeight,
			'calculatedWidth' => $calculatedWidth,
			'nextImagePath' => $nextImagePath,
			'previousImagePath' => $previousImagePath
		);

		$image = $this->objectProvider->getObjectFromArray('\Kabarakh\Mirarse\Domain\Model\Image', $imageObjectArray);
		/** @var $image \Kabarakh\Mirarse\Domain\Model\Image */
		return $image;
	}

}

?>