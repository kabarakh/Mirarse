<?php
namespace TYPO3\Fluid\ViewHelpers\Format;

/*                                                                        *
 * This script is backported from the FLOW3 package "TYPO3.Fluid".        *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 *  of the License, or (at your option) any later version.                *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */
/**
 * Removes tags from the given string (applying PHPs strip_tags() function)
 *
 * @see http://www.php.net/manual/function.strip-tags.php
 * @api
 */
class StripTagsViewHelper extends \TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * Disable the escaping interceptor because otherwise the child nodes would be escaped before this view helper
	 * can decode the text's entities.
	 *
	 * @var boolean
	 */
	protected $escapingInterceptorEnabled = FALSE;

	/**
	 * Escapes special characters with their escaped counterparts as needed using PHPs strip_tags() function.
	 *
	 * @param string $value string to format
	 * @see http://www.php.net/manual/function.strip-tags.php
	 * @api
	 */
	public function render($value = NULL) {
		if ($value === NULL) {
			$value = $this->renderChildren();
		}
		if (!is_string($value)) {
			return $value;
		}
		return strip_tags($value);
	}

}


?>