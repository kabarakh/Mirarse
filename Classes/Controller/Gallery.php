<?php

namespace Kaba\Gallery\Controller;

/**
 * The controller for galleries. Has a list- and a singleView-action
 */
class Gallery extends \Kaba\Gallery\Controller\AbstractController {

	/**
	 * the action to list all galleries available in the configured base folder
	 */
	public function listAction() {
		$galleryRepository = new \Kaba\Gallery\Domain\Repository\Gallery();

		$galleryRootPath = $this->parameter['galleryRootPath'];

		$galleryRepository->getAllGalleriesByRootPath($galleryRootPath, TRUE);

	}
}

?>