<?php

namespace Kaba\Gallery\Domain\Repository;

/**
 * The repository for galleries
 *
 * @property \Kaba\Gallery\FileHandler\Folders $folderHandler
 */
class Gallery extends \Kaba\Gallery\Domain\Repository\AbstractRepository {

	public $injectFolderHandler = '\Kaba\Gallery\FileHandler\Folders';

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