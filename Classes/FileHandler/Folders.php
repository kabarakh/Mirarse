<?php

namespace Kaba\Gallery\FileHandler;

class Folders {

	public function getContentsOfFolder($path, $relative = FALSE) {

		echo "\n\nPath: ".$path."\n\n";
		echo 'Realpath: '.realpath($path)."\n\n";
		if ($relative) {
			$path = $this->getAbsolutePathFromRelativePath($path);
		} else {
			$path = realpath($path);
		}

		$folderContent = scandir($path);

		$folderContent = $this->removeDotDirectoriesFromFolderContent($folderContent);

		foreach ($folderContent as &$filename) {
			echo 'FileName: '.$path.'/'.$filename."\n";

			$filename = $path.'/'.$filename;
		}

		print_r($folderContent, FALSE);

		return ($folderContent);
	}

	protected function getAbsolutePathFromRelativePath($relativePath) {
		$absolutePath = realpath(GALLERY_RUN_DIRECTORY.$relativePath);

		if (!$this->validateFolderExists($absolutePath)) {
			throw new \Exception('Path '.$relativePath.' not accessible or doesn\'t exist', 1357353323);
		}

		echo 'AbsolutePath: '.$absolutePath."\n";

		return $absolutePath;
	}

	protected function validateFolderExists($path) {

		if ($path == FALSE) {
			return FALSE;
		}

		return TRUE;
	}

	protected function removeDotDirectoriesFromFolderContent($folderContent) {
		unset($folderContent[array_search('.', $folderContent)]);
		unset($folderContent[array_search('..', $folderContent)]);

		$folderContent = array_slice($folderContent, 0);

		return $folderContent;
	}

	public function limitResultToFolders($contentsOfRootPath) {
		foreach ($contentsOfRootPath as $key => $filename) {
			if (!is_dir($filename)) {
				unset($contentsOfRootPath[$key]);
			}
		}

		print_r($contentsOfRootPath, FALSE);

		return $contentsOfRootPath;
	}

	/**
	 * A valid folder for the gallery consists of at least one picture and the config file (name gallery.conf)
	 *
	 * @param $contentsOfRootPath
	 */
	public function limitResultToValidFolders($contentsOfRootPath) {

		foreach ($contentsOfRootPath as $key => $foldername) {

			$configFileExists = $this->validateConfigFileExists($foldername);
			$onePictureExists = $this->validateAtLeastOnePictureFileExists($foldername);

			if (!$configFileExists || !$onePictureExists) {
				unset($contentsOfRootPath[$key]);
			}
		}

		$contentsOfRootPath = array_slice($contentsOfRootPath, 0);

		print_r($contentsOfRootPath);

		return $contentsOfRootPath;
	}

	protected function validateConfigFileExists($foldername) {
		$fileHandler = new \Kaba\Gallery\FileHandler\Files();

		return $fileHandler->validateFileExists($foldername.'/gallery.conf');
	}

	protected function validateAtLeastOnePictureFileExists($foldername) {
		$fileHandler = new \Kaba\Gallery\FileHandler\Files();

		$contentsOfFolder = $this->getContentsOfFolder($foldername);

		foreach ($contentsOfFolder as $file) {
			if ($fileHandler->validateFileIsImage($file)) {
				return TRUE;
			}
		}

		return FALSE;
	}

}

?>