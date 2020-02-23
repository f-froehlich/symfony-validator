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
 * Class AbstractLogicalConstraint
 *
 * @Annotation
 * @Target({"PROPERTY", "ANNOTATION"})
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Constraints
 */
abstract class AbstractLogicalConstraint
    extends AbstractConstraint {

    /** @var AbstractConstraint */
    protected $left;

    /** @var AbstractConstraint */
    protected $right;

    /**
     * AbstractBoundConstraint constructor.
     *
     * @param array $options
     */
    public function __construct($options = []) {

        $this->checkParam($options, 'left');
        $this->checkParam($options, 'right');
    }

    /**
     * Check and Set params in options
     *
     * @param array  $options
     * @param string $pos
     */
    private function checkParam(array $options, string $pos): void {
        if (!array_key_exists($pos, $options)) {
            throw new ConstraintDefinitionException("Key '{$pos}' must be set");
        }

        if (!$options[$pos] instanceof AbstractConstraint) {
            throw new ConstraintDefinitionException("Key '{$pos}' must be instance of " . AbstractConstraint::class);
        }
        $this->$pos = $options[$pos];
    }

    /**
     * @return AbstractConstraint
     */
    public function getLeft(): AbstractConstraint {
        return $this->left;
    }

    /**
     * @return AbstractConstraint
     */
    public function getRight(): AbstractConstraint {
        return $this->right;
    }
}
