<?php
namespace TYPO3\Fluid\Configuration;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2009 Jochen Rau <jochen.rau@typoplanet.de>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
/**
 * Abstract base class for a general purpose configuration manager
 *
 * @package TYPO3\Fluid
 * @subpackage Configuration
 * @version $ID:$
 */
abstract class AbstractConfigurationManager implements \TYPO3\Fluid\Object\SingletonInterface {

	/**
	 * Storage of the raw TypoScript configuration
	 *
	 * @var array
	 */
	protected $configuration = array();

	/**
	 * @var \TYPO3\Fluid\Object\ObjectManagerInterface
	 */
	protected $objectManager;

	/**
	 * name of the extension this Configuration Manager instance belongs to
	 *
	 * @var string
	 */
	protected $extensionName;

	/**
	 * name of the plugin this Configuration Manager instance belongs to
	 *
	 * @var string
	 */
	protected $pluginName;

	/**
	 * 1st level configuration cache
	 *
	 * @var array
	 */
	protected $configurationCache = array();

	/**
	 * @param \TYPO3\Fluid\Object\ObjectManagerInterface $objectManager
	 * @return void
	 */
	public function injectObjectManager(\TYPO3\Fluid\Object\ObjectManagerInterface $objectManager) {
		$this->objectManager = $objectManager;
	}

	/**
	 * @return \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer|NULL
	 */
	public function getContentObject() {
		if ($this->contentObject !== NULL) {
			return $this->contentObject;
		}
		return NULL;
	}

	/**
	 * Sets the specified raw configuration coming from the outside.
	 * Note that this is a low level method and only makes sense to be used by Fluid internally.
	 *
	 * @param array $configuration The new configuration
	 * @return void
	 */
	public function setConfiguration(array $configuration = array()) {
		// reset 1st level cache
		$this->configurationCache = array();
		$this->extensionName = isset($configuration['extensionName']) ? $configuration['extensionName'] : NULL;
		$this->pluginName = isset($configuration['pluginName']) ? $configuration['pluginName'] : NULL;
		$this->configuration = $this->typoScriptService->convertTypoScriptArrayToPlainArray($configuration);
	}

	/**
	 * Loads the Fluid Framework configuration.
	 *
	 * The Fluid framework configuration HAS TO be retrieved using this method, as they are come from different places than the normal settings.
	 * Framework configuration is, in contrast to normal settings, needed for the Fluid framework to operate correctly.
	 *
	 * @param string $extensionName if specified, the configuration for the given extension will be returned (plugin.tx_extensionname)
	 * @param string $pluginName if specified, the configuration for the given plugin will be returned (plugin.tx_extensionname_pluginname)
	 * @return array the Fluid framework configuration
	 */
	public function getConfiguration($extensionName = NULL, $pluginName = NULL) {
		return array();
	}

}
