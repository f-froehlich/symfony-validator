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
use FabianFroehlich\Validator\Validator\IsBetweenValidator;

/**
 * Class IsBetween
 *
 * @Annotation
 * @Target({"PROPERTY", "ANNOTATION"})
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Constraints
 */
class IsBetween
    extends AbstractConstraint {

    /** @var float|int */
    public $lowerBound;

    /** @var float|int */
    public $upperBound;

    /** @var bool */
    public $includeLowerBound;

    /** @var bool */
    public $includeUpperBound;

    /**
     * IsBetween constructor.
     *
     * @param array $options
     */
    public function __construct($options = []) {

        if (!is_array($options)) {
            throw new ConstraintDefinitionException('Options must be array');
        }

        if (array_key_exists('lower', $options)) {
            if (!is_int($options['lower']) && !is_float($options['lower'])) {
                throw new ConstraintDefinitionException('Lower Bound must be an integer|float');
            }
        } else {
            throw new ConstraintDefinitionException('Key \'lower\' must be set');
        }

        if (array_key_exists('upper', $options)) {
            if (!is_int($options['upper']) && !is_float($options['upper'])) {
                throw new ConstraintDefinitionException('Upper Bound must be an integer|float');
            }
        } else {
            throw new ConstraintDefinitionException('Key \'upper\' must be set');
        }

        if (array_key_exists('includeLowerBound', $options)) {
            if (!is_bool($options['includeLowerBound'])) {
                throw new ConstraintDefinitionException('Key \'includeLowerBound\' must be bool');
            }
            $this->includeLowerBound = $options['includeLowerBound'];

        } else {
            $this->includeLowerBound = false;
        }

        if (array_key_exists('includeUpperBound', $options)) {
            if (!is_bool($options['includeUpperBound'])) {
                throw new ConstraintDefinitionException('Key \'includeUpperBound\' must be bool');
            }
            $this->includeUpperBound = $options['includeUpperBound'];
        } else {
            $this->includeUpperBound = false;
        }

        if ($options['lower'] > $options['upper']) {
            throw new ConstraintDefinitionException('Lower Bound must be lower or equal Upper Bound');
        }

        $this->lowerBound = $options['lower'];
        $this->upperBound = $options['upper'];
    }

    /**
     * {@inheritDoc}
     */
    public function validatedBy(): string {

        return IsBetweenValidator::class;
    }

    /**
     * @inheritDoc
     */
    public function getTranslationDomain(): string {
        return 'IsBetween';
    }

}
