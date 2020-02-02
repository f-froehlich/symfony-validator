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

/**
 * Class AbstractBoundConstraint
 *
 * @Annotation
 * @Target({"PROPERTY", "ANNOTATION"})
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Constraints
 */
abstract class AbstractBoundConstraint
    extends AbstractConstraint {

    /** @var int|float */
    public $bound;

    /**
     * AbstractBoundConstraint constructor.
     *
     * @param int|float|array $bound
     */
    public function __construct($bound = 0) {


        if (is_array($bound)) {
            if (!array_key_exists('bound', $bound)) {
                throw new ConstraintDefinitionException('Key \'bound\' must be set');
            }
            $bound = $bound['bound'];
        }
        if (!is_int($bound) && !is_float($bound)) {
            throw new ConstraintDefinitionException('Bound must be an integer|float');
        }

        $this->bound = $bound;
    }
}
