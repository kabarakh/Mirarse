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
 * The view class for controllers.
 */
class ControllerView extends \Kabarakh\Mirarse\ClassMagic\GalleryBaseClass {

	/**
	 * @var \Kabarakh\Mirarse\View\ViewConfig
	 * @inject
	 */
	protected $viewConfig;

	/**
	 * @var \Kabarakh\Mirarse\FileSystemHandler\Validator\FileValidator
	 * @inject
	 */
	protected $fileValidator;

	/**
	 * @var \Kabarakh\Mirarse\View\CachedViewHandler
	 * @inject
	 */
	protected $cachedViewHandler;

	/**
	 * Make $object usable in the template with the name $name
	 *
	 * @param $name
	 * @param $object
	 */
	public function assign($name, $object) {
		$this->viewConfig->addToToDisplay($name, $object);
	}

	/**
	 * Make multiple objects usable in the template. The array must have the form
	 * 	array(
	 * 		$name => $object,
	 * 		$name2 => $object2
	 * 	)
	 * be careful!
	 *
	 * @param array $toShow
	 */
	public function assignMultiple(array $toShow) {
		foreach ($toShow as $name => $object) {
			$this->assign($name, $object);
		}
	}

	/**
	 * Override the automatically generated paths to the html files - even if you use the config to use another
	 * root directory
	 *
	 * @param $path
	 */
	public function setNonStandardPath($path) {
		if ($this->fileValidator->validateFileExists($path)) {
			$this->viewConfig->setPathToHtml($path);
		}
	}

	/**
	 * Use controller and action to generate a path
	 * Because this has to work it throws an exception if file isn't present
	 * If nonStandardPath is set earlier, this method does nothing
	 *
	 * @param $controller
	 * @param $action
	 * @throws \Exception
	 */
	public function generatePathAutomatically($controller, $action) {
		$this->viewConfig->setController($controller);
		$this->viewConfig->setAction($action);

		if ($this->viewConfig->getPathToHtml() === '') {
			$baseTemplateFolder = $this->getBaseTemplateFolder();

			$path = $baseTemplateFolder.$controller.'/'.ucfirst($action).'.html';

			if (!$this->fileValidator->validateFileExists($path)) {
				throw new \Exception('Template file '.$path.' not found', 1358550218);
			}
			$this->viewConfig->setPathToHtml($path);
		}
	}

	/**
	 * Reads the config string and builds the path to the template files according to it
	 * if no config is set, use standard templates folder
	 *
	 * @return string
	 */
	protected function getBaseTemplateFolder() {
		if ($GLOBALS['parameter']['templateRootPath']) {
			return MIRARSE_RUN_DIRECTORY.$GLOBALS['parameter']['templateRootPath'].'/';
		}
		return MIRARSE_TEMPLATES;
	}

	/**
	 *
	 */
	public function render() {
		$this->cachedViewHandler->setViewConfig($this->viewConfig);
		$this->cachedViewHandler->getCacheFileToRender();
	}

	/*
	 * folgender ablauf:
	 *
	 * 	- der pfad des views wird im controller-constructor (abstract) gesetzt - automatisch auf /Templates/<Controller>/<Action>.html - done
	 * 	- die variablen kommen über view->assign in das toShow-Array im View-Objekt - done
	 * 	- render wird aufgerufen - done
	 * 		- das toShow-Array serialisieren und den string md5'en -done
	 * 		- timestamp changedate von html-datei abrufen - done
	 * 		- schau in /Cache/Templates nach <Controller>/<Action>/<timestamp>_<md5>.php - done
	 * 		- wenn filemtime älter als 2 tage lösche datei - done
	 * 		- wenn keine datei vorhanden (gilt auch nach löschen) - done
	 * 			- html-file mit file_get_contents auslesen - done
	 * 			- string-ersetzung auf {{objektname.parameter}} zu $toShow['objektname']->getParameter();
	 * 				bzw {{objektname.parameter.parameter2}} zu $toShow['objektname']->getParameter()->getParameter2();
	 * 			- string-ersetzung von {[]} auf die entsprechenden php-funktionen (if, for, foreach, while - zählervariablen implementieren
	 * 				um auf odd/even und so zeug zugreifen zu können - einfügen in toShow und am ende wieder unsetten)
	 * 			- die sonstigen html-bereiche in HEREDOC packen
	 * 			- cache-datei generieren mit methode renderCached() - done
	 * 		- include cache-datei (stellt renderCached() zur verfügung) - done
	 * 		- run renderCached() um HTML auszugeben - done
	 */
}