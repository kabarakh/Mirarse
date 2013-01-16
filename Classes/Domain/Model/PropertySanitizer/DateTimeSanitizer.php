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
namespace Kabarakh\Mirarse\Domain\Model\PropertySanitizer;

/**
 * Validates and cleans DateTime stuff
 */
class DateTimeSanitizer {

	/**
	 * Validate if the date string is of the format mm/dd/yyyy
	 *
	 * @param $dateString
	 *
	 * @return bool
	 * @throws \Exception
	 */
	public function validateDate($dateString) {
		if (!preg_match('@\d{2}/\d{2}/\d{4}@', $dateString)) {
			throw new \Exception('Date string '.$dateString.' is not of format mm/dd/yyyy', 1358194069);
		}
		list($month, $day, $year) = explode('/', $dateString);

		if (!checkdate($month, $day, $year)) {
			throw new \Exception('Date string '.$dateString.' is not a real date', 1358194071);
		}

		return TRUE;
	}
}

?>