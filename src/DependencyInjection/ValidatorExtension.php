<?php

/**
 * Copyright (c) 2020.
 *
 * Class ValidatorExtension.php
 *
 * @author      Fabian Fröhlich <mail@f-froehlich.de>
 *
 * @since       Sat, Jan 4, '20
 * @package     symfony-strict-validator
 */

namespace FabianFroehlich\Validator\DependencyInjection;

use Exception;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;


/**
 * Class ValidatorExtension
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\DependencyInjection
 */
class ValidatorExtension
    extends Extension {

    /**
     * Responds to the app.config configuration parameter.
     *
     * @param array            $configs
     * @param ContainerBuilder $container
     *
     * @throws Exception
     */
    public function load(array $configs, ContainerBuilder $container) {

    }
}
