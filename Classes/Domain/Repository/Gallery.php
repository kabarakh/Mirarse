<?php

namespace Kaba\Gallery\Domain\Repository;

/**
 * The repository for galleries
 */
class Gallery {

	/**
	 * @param $rootPath String
	 *
	 * @throws \Exception
	 */
	public function getAllGalleriesByRootPath($rootPath) {
		$folderHandler = new \Kaba\Gallery\FileHandler\Folders();

		$contentsOfRootPath = $folderHandler->getContentsOfFolder($rootPath);

		$contentsOfRootPath = $folderHandler->limitResultToFolders($contentsOfRootPath);

		$contentsOfRootPath = $folderHandler->limitResultToValidFolders($contentsOfRootPath);



	}
}