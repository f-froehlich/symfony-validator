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

namespace FabianFroehlich\Validator\Constraints;


use FabianFroehlich\Validator\Exception\ConstraintDefinitionException;
use FabianFroehlich\Validator\Validator\IsOptionalValidator;

/**
 * Class IsOptional
 *
 * @Annotation
 * @Target({"PROPERTY", "ANNOTATION"})
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Constraints
 */
class IsOptional
    extends AbstractConstraint {

    /** @var AbstractConstraint */
    public $constraint;

    /**
     * {@inheritDoc}
     */
    public function __construct($constraint = []) {

        if (is_array($constraint)) {
            if (!array_key_exists('constraint', $constraint)) {
                throw new ConstraintDefinitionException('Key \'constraint\' must be set');
            }
            $constraint = $constraint['constraint'];
        }
        if (!($constraint instanceof AbstractConstraint)) {
            throw new ConstraintDefinitionException('Constraint must be type of ' . AbstractConstraint::class);
        }

        $this->constraint = $constraint;
    }

    /**
     * {@inheritDoc}
     */
    public function validatedBy(): string {

        return IsOptionalValidator::class;
    }

    /**
     * @inheritDoc
     */
    public function getTranslationDomain(): string {
        return 'IsOptional';
    }

}
