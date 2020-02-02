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

namespace FabianFroehlich\Validator\Violation;

use FabianFroehlich\Validator\Constraints\AbstractConstraint;
use FabianFroehlich\Validator\Validator\AbstractConstraintValidator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class DataConstraintViolationBuilder
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Violation
 */
class DataConstraintViolationBuilder
    extends AbstractConstraintViolationBuilder {

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * ConstraintViolationBuilder constructor.
     *
     * @param ContainerInterface  $container
     * @param TranslatorInterface $translator
     */
    public function __construct(ContainerInterface $container, TranslatorInterface $translator) {

        parent::__construct($translator);
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function validateValue($value, AbstractConstraint $constraint): bool {

        /** @var AbstractConstraintValidator $validator */
        $validator = $this->container->get($constraint->validatedBy());
        $validator->setViolationBuilder($this);
        return $validator->validate($value, $constraint);
    }

}
