<?php
namespace TYPO3\Fluid\Core\Parser;

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
 * This interface is returned by Tx_Fluid_Core_Parser_TemplateParser->parse()
 * method and is a parsed template
 */
interface ParsedTemplateInterface
{
	/**
	 * Render the parsed template with rendering context
	 *
	 * @param \TYPO3\Fluid\Core\Rendering\RenderingContextInterface $renderingContext The rendering context to use
	 * @return Rendered string
	 */
	public function render(\TYPO3\Fluid\Core\Rendering\RenderingContextInterface $renderingContext);

	/**
	 * Returns a variable container used in the PostParse Facet.
	 *
	 * @return \TYPO3\Fluid\Core\ViewHelper\TemplateVariableContainer
	 */
	// TODO remove
	public function getVariableContainer();

	/**
	 * Returns the name of the layout that is defined within the current template via <f:layout name="..." />
	 * If no layout is defined, this returns NULL
	 * This requires the current rendering context in order to be able to evaluate the layout name
	 *
	 * @param \TYPO3\Fluid\Core\Rendering\RenderingContextInterface $renderingContext
	 * @return string
	 */
	public function getLayoutName(\TYPO3\Fluid\Core\Rendering\RenderingContextInterface $renderingContext);

	/**
	 * Returns TRUE if the current template has a template defined via <f:layout name="..." />
	 *
	 * @see getLayoutName()
	 * @return boolean
	 */
	public function hasLayout();

	/**
	 * If the template contains constructs which prevent the compiler from compiling the template
	 * correctly, isCompilable() will return FALSE.
	 *
	 * @return boolean TRUE if the template can be compiled
	 */
	public function isCompilable();

	/**
	 * @return boolean TRUE if the template is already compiled, FALSE otherwise
	 */
	public function isCompiled();

}

?>