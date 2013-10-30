<?php
namespace TYPO3\Fluid\DependencyInjection;

/*                                                                        *
 * This script is part of the TYPO3 project - inspiring people to share!  *
 *                                                                        *
 * TYPO3 is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License version 2 as published by  *
 * the Free Software Foundation.                                          *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General      *
 * Public License for more details.                                       *
 *                                                                        */

use TYPO3\Fluid\Loader\FilesystemLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;

class FluidExtension extends Extension {

	/**
	 * @param array $configs
	 * @param ContainerBuilder $container
	 */
	public function load(array $configs, ContainerBuilder $container) {
		$configLoader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/Config'));
		$configLoader->load('Fluid.service.xml');
		$config = array();
		foreach ($configs as $subConfig) {
			$config = array_merge($config, $subConfig);
		}
		$container->setParameter('fluid', $config);
	}

	/**
	 * @return string
	 */
	public function getAlias() {
		return 'fluid';
	}
}