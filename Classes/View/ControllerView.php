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
 *
 * @method render
 */
class ControllerView extends \Kabarakh\Mirarse\ClassMagic\GalleryBaseClass {

	/**
	 * Magic function to do anything...
	 *
	 * @param $functionName
	 * @param $arguments
	 */
	public function __call($functionName, $arguments) {
		echo "Doing function ".$functionName."\n";
	}


	/*
	 * folgender ablauf:
	 *
	 * 	- der pfad des views wird im controller-constructor (abstract) gesetzt - automatisch auf /Templates/<Controller>/<Action>.html
	 * 	- die variablen kommen über view->assign in das toShow-Array im View-Objekt
	 * 	- render wird aufgerufen
	 * 		- das toShow-Array serialisieren und den string md5'en
	 * 		- timestamp changedate von html-datei abrufen
	 * 		- schau in /Cache/Templates nach <Controller>/<Action>/<timestamp>_<md5>.php
	 * 		- wenn filemtime älter als 2 tage lösche datei
	 * 		- wenn keine datei vorhanden (gilt auch nach löschen)
	 * 			- html-file mit file_get_contents auslesen
	 * 			- string-ersetzung auf {{objektname.parameter}} zu $toShow['objektname']->getParameter();
	 * 				bzw {{objektname.parameter.parameter2}} zu $toShow['objektname']->getParameter()->getParameter2();
	 * 			- string-ersetzung von {[]} auf die entsprechenden php-funktionen (if, for, foreach, while - zählervariablen implementieren
	 * 				um auf odd/even und so zeug zugreifen zu können - einfügen in toShow und am ende wieder unsetten)
	 * 			- die sonstigen html-bereiche in HEREDOC packen
	 * 			- cache-datei generieren mit methode renderCached()
	 * 		- include cache-datei (stellt renderCached() zur verfügung)
	 * 		- run renderCached() um HTML auszugeben
	 */
}