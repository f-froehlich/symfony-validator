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
 * Class ConstraintViolation
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator
 */
class ConstraintViolation {

    /** @var string */
    private $message;

    /** @var string */
    private $propertyPath;

    /** @var mixed */
    private $invalidValue;

    /** @var AbstractConstraint|null */
    private $constraint;

    /** @var string|null */
    private $code;

    /**
     * Creates a new constraint violation.
     *
     * @param string                  $message      The violation message as a string or a stringable object
     *                                              raw violation message
     * @param string                  $propertyPath The property path from the root
     *                                              value to the invalid value
     * @param mixed                   $invalidValue The invalid value that caused this
     *                                              violation
     *                                              form when translating the message
     * @param string|null             $code         The error code of the violation
     * @param AbstractConstraint|null $constraint
     */
    public function __construct(
        string $message,
        string $propertyPath,
        $invalidValue,
        ?string $code,
        ?AbstractConstraint $constraint
    ) {

        $this->message      = $message;
        $this->propertyPath = $propertyPath;
        $this->invalidValue = $invalidValue;
        $this->constraint   = $constraint;
        $this->code         = $code;
    }

    /**
     * @return string Message of failure
     */
    public function getMessage(): string {

        return $this->message;
    }

    /**
     * @return string Get the path, where validation error happen
     */
    public function getPropertyPath(): string {

        return $this->propertyPath;
    }

    /**
     * @return mixed get the wrong value
     */
    public function getInvalidValue() {

        return $this->invalidValue;
    }

    /**
     * Returns the constraint whose validation caused the violation.
     *
     * @return AbstractConstraint|null The constraint or null if it is not known
     */
    public function getConstraint(): ?AbstractConstraint {

        return $this->constraint;
    }

    /**
     * @return string|null Error code or null if no exist
     */
    public function getCode(): ?string {

        return $this->code;
    }

}
