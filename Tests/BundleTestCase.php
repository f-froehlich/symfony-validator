<?php
/**
 * Symfony Validator
 *
 * Type sensitive validating Software for Symfony Applications.
 *
 * Copyright (c) 2020 Fabian Fröhlich <mail@f-froehlich.de> https://f-froehlich.de
 *
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 *
 * For all license terms see README.md and LICENSE Files in root directory of this Project.
 *
 */

namespace FabianFroehlich\Validator\Tests;


use FabianFroehlich\Core\Util\Test\FastIntegrationTestCase;
use FabianFroehlich\Validator\DependencyInjection\ValidatorExtension;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\DependencyInjection\FrameworkExtension;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;


/**
 * Class BundleTestCase
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Tests
 */
abstract class BundleTestCase
    extends FastIntegrationTestCase {

    protected function loadExtensions(ContainerInterface $container): void {
        (new FrameworkExtension())->load([], $container);
        (new ValidatorExtension())->load([], $container);

        $loader = new XmlFileLoader($container, new FileLocator(dirname(__DIR__) . '/Tests'));
        $loader->load('testconfig.xml');

    }

    protected function getBundles(): array {
        return ['FrameworkBundle' => 'FabianFroehlich\\Validator\\Validator'];
    }

    protected function getBundlesMetadata(): array {
        return ['FrameworkBundle' => ['namespace' => 'FabianFroehlich\\Validator', 'path' => __DIR__ . '/../..']];
    }
}