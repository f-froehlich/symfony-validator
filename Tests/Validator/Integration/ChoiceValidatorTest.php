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


namespace FabianFroehlich\Validator\Tests\Validator\Integration;


use FabianFroehlich\Validator\Constraints\AbstractConstraint;
use FabianFroehlich\Validator\Constraints\Choice;
use FabianFroehlich\Validator\Enums\ErrorCodes;
use FabianFroehlich\Validator\Tests\ValidatorTestCase;
use FabianFroehlich\Validator\Validator\AbstractConstraintValidator;
use FabianFroehlich\Validator\Violation\ConstraintViolation;

/**
 * Class ChoiceValidatorTest
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Tests\Validator\Integration
 */
class ChoiceValidatorTest
    extends ValidatorTestCase {

    /**
     * @test
     */
    public function checkCollectionCorrectWithoutRecursion(): void {

        $constraint = $this->initConstraint(
            [
                1,
                2.0,
                'three',
            ]
        );

        $this->validator->validate(1, $constraint);
        $this->validator->validate(2.0, $constraint);
        $this->validator->validate('three', $constraint);

        $this->assertCount(0, $this->validatorBuilder->getViolations());
    }

    private function initConstraint(array $options): AbstractConstraint {

        $class = $this->getConstraintClass();

        return new $class($options);
    }

    /**
     * {@inheritDoc}
     */
    protected function getConstraintClass(): string {

        return Choice::class;
    }

    /**
     * @test
     */
    public function checkCollectionCorrectWithRecursion(): void {


        $constraint = $this->initConstraint(
            [
                1,
                2.0,
                'three',
            ]
        );

        $this->validator->validate('random', $constraint);

        /** @var ConstraintViolation[] $violations */
        $violations = $this->validatorBuilder->getViolations();
        $this->assertCount(1, $violations);

        $this->assertEquals('random', $violations[0]->getInvalidValue());
        $this->assertEquals('', $violations[0]->getPropertyPath());
        $this->assertEquals(ErrorCodes::NOT_IN_CHOICES()->value(), $violations[0]->getCode());
        $this->assertEquals($constraint, $violations[0]->getConstraint());
    }

    protected function getRequiredType(): string {
        return AbstractConstraintValidator::NUMBER_OR_STRING;
    }

    /**
     * {@inheritDoc}
     */
    protected function getConstraint(): AbstractConstraint {

        return $this->initConstraint($this->getAllTypesWithValues());
    }

    /**
     * Get the types that are valid for the Validator
     *
     * @return array
     */
    protected function getValidTypes(): array {

        return [
            self::NUMBER_OR_STRING_STRING,
            self::NUMBER_OR_STRING_INT,
            self::NUMBER_OR_STRING_FLOAT,
            self::INT,
            self::INT_NEGATIVE,
            self::INT_POSITIVE,
            self::INT_ZERO,
            self::STRING,
            self::FLOAT,
            self::FLOAT_NEGATIVE,
            self::FLOAT_POSITIVE,
            self::FLOAT_ZERO,
        ];
    }


}