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

/**
 * Interface ConstraintViolationBuilderInterface
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Violation
 */
interface ConstraintViolationBuilderInterface {

    /**
     * Stores the property path at which the violation should be generated.
     *
     * The passed path will be appended to the current property path of the
     * execution context.
     *
     * @param string $path The property path
     *
     * @return $this
     */
    public function setPath(string $path): ConstraintViolationBuilderInterface;

    /**
     * Get the current Path
     *
     * @return string
     */
    public function getPath(): string;

    /**
     * Get all violations
     *
     * @return ConstraintViolation[]
     */
    public function getViolations(): array;

    /**
     * Get the ConstraintViolationList
     *
     * @return ConstraintViolationList
     */
    public function getViolationList(): ConstraintViolationList;

    /**
     * Resets all violations
     */
    public function reset(): void;

    /**
     * Adds the violation to the current execution context.
     *
     * @param                    $invalidValue
     * @param string             $code
     * @param array              $params
     * @param AbstractConstraint $constraint
     *
     * @return ConstraintViolationBuilderInterface
     */
    public function addViolation(
        $invalidValue,
        string $code,
        array $params,
        AbstractConstraint $constraint
    ): ConstraintViolationBuilderInterface;

    /**
     * Validate a value
     *
     * @param                    $value
     * @param AbstractConstraint $constraint
     *
     * @return bool
     */
    public function validateValue($value, AbstractConstraint $constraint): bool;

}
