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
namespace Kabarakh\Mirarse\View;

/**
 * Does everything which has to do with the cache files and cached code
 */
class CachedViewHandler extends \Kabarakh\Mirarse\ClassMagic\GalleryBaseClass {

	/**
	 * @var string
	 */
	protected $pathToCacheFile;

	/**
	 * @var string
	 */
	protected $cachedViewClassName;

	/**
	 * @var \Kabarakh\Mirarse\FileSystemHandler\Validator\FileValidator
	 * @inject
	 */
	protected $fileValidator;

	/**
	 * @var \Kabarakh\Mirarse\FileSystemHandler\FileHandler
	 * @inject
	 */
	protected $fileHandler;

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
	 * @var \Kabarakh\Mirarse\View\ViewConfig
	 * @inject
	 */
	protected $viewConfig;

	/**
	 * @var \Kabarakh\Mirarse\View\TemplateParser
	 * @inject
	 */
	protected $templateParser;

	/**
	 * @param \Kabarakh\Mirarse\View\ViewConfig $viewConfig
	 */
	public function setViewConfig($viewConfig) {
		$this->viewConfig = $viewConfig;
	}

	/**
	 * @return \Kabarakh\Mirarse\View\ViewConfig
	 */
	public function getViewConfig() {
		return $this->viewConfig;
	}

	/**
	 * Gets the cache file for the action-object-combination
	 * checks if the cache files are to old and removes them if they are
	 * builds a new cache file if needed
	 * includes the file in the end and calls the render function so we get content to display
	 */
	public function getCacheFileToRender() {
		$this->pathToCacheFile = $this->generateCacheFileName();

		var_dump($this->pathToCacheFile);

		$this->cleanUpOldCacheFiles();

		if (!$this->fileValidator->validateFileExists($this->pathToCacheFile)) {
			echo "creating new \n";

			$this->templateParser->setViewConfig($this->viewConfig);
			$this->templateParser->setCachedViewClassName($this->cachedViewClassName);
			$this->templateParser->setPathToCacheFile($this->pathToCacheFile);

			$this->templateParser->generateCacheFile();
		}

		require_once($this->pathToCacheFile);

		/** @var $cachedView \Kabarakh\Mirarse\View\AbstractCachedView */
		$fullClassPath = '\\Kabarakh\\Mirarse\\View\\'.$this->cachedViewClassName;
		$cachedView = new $fullClassPath;
		$cachedView->setToDisplay($this->viewConfig->getToDisplay());
		$cachedView->renderCached();
	}

	/**
	 * generate the name of the cache file
	 *
	 * @return string
	 */
	public function generateCacheFileName() {
		$folderString = $this->generateBasePathToCacheFile();
		$this->generateCachedViewClassName();

		$path = $folderString.$this->cachedViewClassName.'.php';

		return $path;
	}

	/**
	 * generate the class name of the cache class
	 */
	protected function generateCachedViewClassName() {
		$timestamp = $this->getLastChangeOfHtmlFile();
		$md5Hash = $this->getMd5HashOfToDisplayArray();

		$this->cachedViewClassName = 'CachedView_'.$timestamp.'_'.$md5Hash;
	}

	/**
	 * gets the timestamp of the change date of the html template file. That way we can check if the cache file uses
	 * the most recent version
	 *
	 * @return int
	 */
	protected function getLastChangeOfHtmlFile() {
		$pathToHtml = $this->viewConfig->getPathToHtml();
		$timestamp = $this->fileHandler->getTimeStampOfLastChangeOfFile(	$pathToHtml);

		return $timestamp;
	}

	/**
	 * builds an md5-hash (with salt) out of the serialized toDisplay-object
	 * that way we can identify which controller-action-object combination has which cache file
	 *
	 * @return string
	 */
	protected function getMd5HashOfToDisplayArray() {
		$toDisplay = $this->viewConfig->getToDisplay();
		$serializedString = serialize($toDisplay);
		$md5String = md5('SaltBefore123'.$serializedString.'321SaltAfter');

		return $md5String;
	}

	/**
	 * generates the folder where the cache file is supposed to be.
	 * uses the form <run_directory>/Cache/<Controller>/<Action>
	 *
	 * if the folder doesn't exist, this method creates the folder
	 *
	 * @return string
	 */
	protected function generateBasePathToCacheFile() {
		$controller = $this->viewConfig->getController();
		$action = ucfirst($this->viewConfig->getAction());

		$path = MIRARSE_CACHE.$controller.'/'.$action.'/';

		if (!$this->folderValidator->validateFolderExists($path)) {
			$this->folderHandler->generateFolderPath($path);
		}

		return $path;
	}

	/**
	 * Remove cache files older than 2 days (2 days * 24 hours * 60 minutes * 60 seconds)
	 */
	protected function cleanUpOldCacheFiles() {
		$folder = dirname($this->pathToCacheFile);

		$folderContent = $this->folderHandler->getContentsOfFolder($folder);
		if ($folderContent === NULL) {
			return;
		}
		foreach ($folderContent->getContent() as $singleCacheFile) {
			if ($this->fileHandler->getAgeOfCacheFile($singleCacheFile) > (2 * 24 * 60 * 60)) {
				$this->fileHandler->deleteFile($singleCacheFile);
			}
		}
	}


}

?>