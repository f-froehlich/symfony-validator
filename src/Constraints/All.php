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
use FabianFroehlich\Validator\Validator\AllValidator;

/**
 * Class All
 *
 * @Annotation
 * @Target({"PROPERTY", "ANNOTATION"})
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Constraints
 */
class All
    extends AbstractConstraint {

    /** @var Collection */
    public $constraints;

    /**
     * All constructor.
     *
     * @param Collection $constraints
     */
    public function __construct($constraints = []) {
        if (is_array($constraints)) {
            if (!array_key_exists('collection', $constraints)) {
                throw new ConstraintDefinitionException('Key \'collection\' must be set');
            }
            $constraints = $constraints['collection'];
        }

        if (!($constraints instanceof Collection)) {
            throw new ConstraintDefinitionException(
                __CLASS__ . ' can only have ' . Collection::class . ' as Constraint'
            );
        }
        $this->constraints = $constraints;
    }

    /**
     * {@inheritDoc}
     */
    public function validatedBy(): string {

        return AllValidator::class;
    }


    /**
     * @inheritDoc
     */
    public function getTranslationDomain(): string {
        return 'All';
    }
}
