<?php

namespace Kaba\Gallery\Domain\Repository;

class Gallery {

	/**
	 * @param $rootPath String
	 */
	public function getAllGalleriesByRootPath($rootPath) {
		$absolutePathToGalleries = realpath(GALLERY_RUN_DIRECTORY.$rootPath);

		if ($absolutePathToGalleries == FALSE) {
			throw new \Exception('GalleryRootPath not accessible or doesn\'t exist', 1357353323);
		}

		echo 'AbsolutePathToGalleries: '.$absolutePathToGalleries."\n";
	}
}