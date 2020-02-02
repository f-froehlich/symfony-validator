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

namespace FabianFroehlich\Validator\Validator;

use ArrayAccess;
use FabianFroehlich\Validator\Constraints\AbstractConstraint;
use FabianFroehlich\Validator\Enums\ErrorCodes;
use FabianFroehlich\Validator\Exception\UnexpectedTypeException;
use FabianFroehlich\Validator\Violation\ConstraintViolationBuilderInterface;
use Traversable;
use function is_array;
use function is_object;
use function is_string;

/**
 * Class AbstractConstraintValidator
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Validator
 */
abstract class AbstractConstraintValidator {

    public const ALL = 'ALL';

    public const NUMBER_OR_STRING = 'NUMBER_OR_STRING';

    public const STRING = 'string';

    public const INT = 'integer';

    public const NUMBER = 'NUMBER';

    public const FLOAT = 'double';

    public const BOOLEAN = 'boolean';

    public const NULL = 'NULL';

    public const ARRAY = 'array';

    public const LIST = 'LIST';

    public const STD_CLASS = 'stdClass';

    public const RESOURCE = 'resource';

    public const OPTIONAL = 'OPTIONAL';

    /**
     * @var ConstraintViolationBuilderInterface
     */
    protected $violationBuilder;

    public function __construct(ConstraintViolationBuilderInterface $violationBuilder) {

        $this->violationBuilder = $violationBuilder;
    }

    /**
     * Validate a value wih a constraint
     *
     * @param                    $value
     * @param AbstractConstraint $constraint
     *
     * @return bool
     */
    final public function validate($value, AbstractConstraint $constraint): bool {

        $constraintClass = $this->getRequiredConstraint();
        if (!$constraint instanceof $constraintClass) {
            throw new UnexpectedTypeException($constraint, $constraintClass);

        }
        $valueType = is_object($value) ? get_class($value) : gettype($value);

        if (self::LIST === $this->getRequiredType()) {

            if (!is_array($value) && !($value instanceof Traversable && $value instanceof ArrayAccess)) {

                $this->violationBuilder->addViolation(
                    $value,
                    ErrorCodes::INVALID_VALUE_TYPE()->value(),
                    ['expected' => 'array|(Traversable&ArrayAccess)', 'got' => $valueType],
                    $constraint
                );

                return false;
            }
        } else if (self::NUMBER === $this->getRequiredType()) {

            if (!is_int($value) && !is_float($value)) {

                $this->violationBuilder->addViolation(
                    $value,
                    ErrorCodes::INVALID_VALUE_TYPE()->value(),
                    ['expected' => 'integer|float', 'got' => $valueType],
                    $constraint
                );

                return false;
            }
        } else if (self::NUMBER_OR_STRING === $this->getRequiredType()) {

            if (!is_int($value) && !is_float($value) && !is_string($value)) {

                $this->violationBuilder->addViolation(
                    $value,
                    ErrorCodes::INVALID_VALUE_TYPE()->value(),
                    ['expected' => 'integer|float|string', 'got' => $valueType],
                    $constraint
                );

                return false;
            }
        } else if (self::ALL !== $this->getRequiredType() && self::OPTIONAL !== $this->getRequiredType()) {

            if ($valueType !== $this->getRequiredType()) {
                $this->violationBuilder->addViolation(
                    $value,
                    ErrorCodes::INVALID_VALUE_TYPE()->value(),
                    ['expected' => $this->getRequiredType(), 'got' => $valueType],
                    $constraint
                );

                return false;
            }
        }

        return $this->customValidation($value, $constraint);

    }

    /**
     * Get the constraint, that is used for Validator
     *
     * @return string
     */
    abstract public function getRequiredConstraint(): string;

    /**
     * Get the required data type of value
     *
     * @return string
     */
    abstract public function getRequiredType(): string;

    /**
     * Make the custom validation of an Validation Request
     *
     * @param mixed              $value      Type checked value
     * @param AbstractConstraint $constraint type checked Constraint
     *
     * @return bool
     */
    abstract protected function customValidation($value, AbstractConstraint $constraint): bool;

    /**
     * set the violation Builder
     *
     * @param ConstraintViolationBuilderInterface $builder
     *
     * @return AbstractConstraintValidator
     */
    public function setViolationBuilder(ConstraintViolationBuilderInterface $builder): AbstractConstraintValidator {
        $this->violationBuilder = $builder;
        return $this;
    }

}
