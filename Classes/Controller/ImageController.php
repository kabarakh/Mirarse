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

namespace Kabarakh\Mirarse\Controller;

/**
 * The controller for galleries. Has a list- and a singleView-action
 */
class ImageController extends \Kabarakh\Mirarse\Controller\BaseController {

	/**
	 * @var  \Kabarakh\Mirarse\Domain\Repository\ImageRepository
	 * @inject
	 */
	protected $imageRepository;

	/**
	 * @var \Kabarakh\Mirarse\Domain\Repository\SingleGalleryConfigRepository
	 * @inject
	 */
	protected $singleGalleryConfigRepository;

	/**
	 * @throws \Exception
	 */
	public function singleAction() {
		$imagePath = $GLOBALS['parameter']['imagePath'];

		if (empty($imagePath)) {
			throw new \Exception('imagePath is empty', 1370774049);
		}

		$config = $this->singleGalleryConfigRepository->generateSingleGalleryConfigFromPath(dirname($imagePath));

		$image = $this->imageRepository->generateImageFromPathWithSingleGalleryConfig($imagePath, $config);

		$this->view->assign('image', $image);
	}

}


?>