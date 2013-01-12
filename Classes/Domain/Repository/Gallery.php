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
 *
 * @property \Kaba\Gallery\FileHandler\Folders $folderHandler
 */
class Gallery extends \Kaba\Gallery\Domain\Repository\AbstractRepository {

	/**
	 * @var \Kaba\Gallery\FileHandler\Folders
	 * @inject
	 */
	protected $folderHandler;

	/**
	 * @param $rootPath String
	 *
	 * @throws \Exception
	 */
	public function getAllGalleriesByRootPath($rootPath) {

		$contentsOfRootPath = $this->folderHandler->getContentsOfFolder($rootPath);

		$contentsOfRootPath = $this->folderHandler->limitResultToFolders($contentsOfRootPath);

		$contentsOfRootPath = $this->folderHandler->limitResultToValidFolders($contentsOfRootPath);

		$galleryList = array();

		foreach ($contentsOfRootPath as $singleFolder) {
			$gallery[] = $this->createGalleryFromPath($singleFolder);
		}

	}

	/**
	 * Creates a gallery object from a provided path
	 * get config, images and stuff
	 *
	 * @param $singleFolder
	 */
	protected function createGalleryFromPath($singleFolder) {
		$folderContent = $this->folderHandler->getContentsOfFolder($singleFolder);

		echo "\n\nbefore: \n";
		var_dump($folderContent);

		$folderContent = $this->folderHandler->limitResultToImages($folderContent);
		echo "\nafter: \n";
		var_dump($folderContent);

		$configFileContent = $this->folderHandler->getConfigFileFromFolder($singleFolder);


		#$gallery = \Kaba\Gallery\Domain\Model\Gallery::getObjectFromArray();
	}
}