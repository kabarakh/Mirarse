<?php

namespace Kaba\Gallery\FileHandler;

class Files {
	public function validateFileIsImage($pathToFile) {
		if (!$this->validateFileExists($pathToFile)) {
			return FALSE;
		}

		$finfo = new \finfo();

		$mimeType = $finfo->file($pathToFile, FILEINFO_MIME_TYPE);

		echo 'MimeType: '.$mimeType."\n";

		if (strncmp($mimeType, 'image/', 6) === 0) {
			return TRUE;
		}
		return FALSE;
	}

	public function validateFileExists($pathToFile) {
		if (is_file($pathToFile)) {
			return TRUE;
		}
		return FALSE;
	}
}

?>