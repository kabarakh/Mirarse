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

namespace Kaba\Gallery\Domain\Repository;

/**
 * The repository for galleries
 */
class GalleryRepository extends \Kaba\Gallery\Domain\Repository\AbstractRepository {

	/**
	 * @var \Kaba\Gallery\FileSystemHandler\FolderHandler
	 * @inject
	 */
	protected $folderHandler;

	/**
	 * @param $rootPath string
	 *
	 * @throws \Exception
	 */
	public function getAllGalleriesByRootPath($rootPath) {

		/** @var $contentsOfRootPath \Kaba\Gallery\FileSystemHandler\FolderContentHandler */
		$contentsOfRootPath = $this->folderHandler->getContentsOfFolder($rootPath);

		$contentsOfRootPath->limitResultToFolders();

		$contentsOfRootPath->limitResultToValidFolders();

		$galleryList = array();

		foreach ($contentsOfRootPath->getContent() as $singleFolder) {
			$galleryList[] = $this->createGalleryFromPath($singleFolder);
		}

	}

	/**
	 * Creates a gallery object from a provided path
	 * get config, images and stuff
	 *
	 * @param $singleFolder
	 */
	protected function createGalleryFromPath($singleFolder) {
		/** @var $folderContent \Kaba\Gallery\FileSystemHandler\FolderContentHandler */
		$folderContent = $this->folderHandler->getContentsOfFolder($singleFolder);

		$folderContent->limitResultToImages();

		$configFileContent = $this->folderHandler->getConfigFileFromFolder($singleFolder);



		#$gallery = \Kaba\Gallery\Domain\Model\Gallery::getObjectFromArray();
	}
}