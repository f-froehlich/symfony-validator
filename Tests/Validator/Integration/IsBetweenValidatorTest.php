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
use FabianFroehlich\Validator\Constraints\IsBetween;
use FabianFroehlich\Validator\Enums\ErrorCodes;
use FabianFroehlich\Validator\Tests\ValidatorTestCase;
use FabianFroehlich\Validator\Validator\AbstractConstraintValidator;
use FabianFroehlich\Validator\Violation\ConstraintViolation;

/**
 * Class IsBetweenValidatorTest
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Tests\Validator\Integration
 */
class IsBetweenValidatorTest
    extends ValidatorTestCase {

    /**
     * @test
     */
    public function notAcceptIntLowerWithoutIncludeBound(): void {

        $constraint = new IsBetween(['lower' => -1, 'upper' => 1]);

        $this->validator->validate(-1, $constraint);

        /** @var ConstraintViolation[] $violations */
        $violations = $this->validatorBuilder->getViolations();
        $this->assertCount(1, $violations);

        $this->assertEquals(-1, $violations[0]->getInvalidValue());
        $this->assertEmpty($violations[0]->getPropertyPath());
        $this->assertEquals(ErrorCodes::NOT_BETWEEN_ERROR()->value(), $violations[0]->getCode());
        $this->assertEquals($constraint, $violations[0]->getConstraint());
    }

    /**
     * @test
     */
    public function notAcceptIntLowerWithIncludeBound(): void {

        $constraint = new IsBetween(['lower' => -1, 'upper' => 1, 'includeLowerBound' => true]);

        $this->validator->validate(-2, $constraint);

        /** @var ConstraintViolation[] $violations */
        $violations = $this->validatorBuilder->getViolations();
        $this->assertCount(1, $violations);

        $this->assertEquals(-2, $violations[0]->getInvalidValue());
        $this->assertEmpty($violations[0]->getPropertyPath());
        $this->assertEquals(ErrorCodes::NOT_BETWEEN_ERROR()->value(), $violations[0]->getCode());
        $this->assertEquals($constraint, $violations[0]->getConstraint());
    }

    /**
     * @test
     */
    public function notAcceptFloatLowerWithoutIncludeBound(): void {

        $constraint = new IsBetween(['lower' => -1, 'upper' => 1]);

        $this->validator->validate(-1.0, $constraint);

        /** @var ConstraintViolation[] $violations */
        $violations = $this->validatorBuilder->getViolations();
        $this->assertCount(1, $violations);

        $this->assertEquals(-1.0, $violations[0]->getInvalidValue());
        $this->assertEmpty($violations[0]->getPropertyPath());
        $this->assertEquals(ErrorCodes::NOT_BETWEEN_ERROR()->value(), $violations[0]->getCode());
        $this->assertEquals($constraint, $violations[0]->getConstraint());
    }

    /**
     * @test
     */
    public function notAcceptFloatLowerWithIncludeBound(): void {

        $constraint = new IsBetween(['lower' => -1, 'upper' => 1, 'includeLowerBound']);

        $this->validator->validate(-1.1, $constraint);

        /** @var ConstraintViolation[] $violations */
        $violations = $this->validatorBuilder->getViolations();
        $this->assertCount(1, $violations);

        $this->assertEquals(-1.1, $violations[0]->getInvalidValue());
        $this->assertEmpty($violations[0]->getPropertyPath());
        $this->assertEquals(ErrorCodes::NOT_BETWEEN_ERROR()->value(), $violations[0]->getCode());
        $this->assertEquals($constraint, $violations[0]->getConstraint());
    }

    /**
     * @test
     */
    public function notAcceptIntUpperWithoutIncludeBound(): void {

        $constraint = new IsBetween(['lower' => -1, 'upper' => 1]);

        $this->validator->validate(1, $constraint);

        /** @var ConstraintViolation[] $violations */
        $violations = $this->validatorBuilder->getViolations();
        $this->assertCount(1, $violations);

        $this->assertEquals(1, $violations[0]->getInvalidValue());
        $this->assertEmpty($violations[0]->getPropertyPath());
        $this->assertEquals(ErrorCodes::NOT_BETWEEN_ERROR()->value(), $violations[0]->getCode());
        $this->assertEquals($constraint, $violations[0]->getConstraint());
    }

    /**
     * @test
     */
    public function notAcceptIntUpperWithIncludeBound(): void {

        $constraint = new IsBetween(
            ['lower' => -1, 'upper' => 1, 'includeLowerBound' => true, 'includeUpperBound' => true]
        );

        $this->validator->validate(2, $constraint);

        /** @var ConstraintViolation[] $violations */
        $violations = $this->validatorBuilder->getViolations();
        $this->assertCount(1, $violations);

        $this->assertEquals(2, $violations[0]->getInvalidValue());
        $this->assertEmpty($violations[0]->getPropertyPath());
        $this->assertEquals(ErrorCodes::NOT_BETWEEN_ERROR()->value(), $violations[0]->getCode());
        $this->assertEquals($constraint, $violations[0]->getConstraint());
    }

    /**
     * @test
     */
    public function notAcceptFloatUpperWithoutIncludeBound(): void {

        $constraint = new IsBetween(['lower' => -1, 'upper' => 1]);

        $this->validator->validate(1.0, $constraint);

        /** @var ConstraintViolation[] $violations */
        $violations = $this->validatorBuilder->getViolations();
        $this->assertCount(1, $violations);

        $this->assertEquals(1.0, $violations[0]->getInvalidValue());
        $this->assertEmpty($violations[0]->getPropertyPath());
        $this->assertEquals(ErrorCodes::NOT_BETWEEN_ERROR()->value(), $violations[0]->getCode());
        $this->assertEquals($constraint, $violations[0]->getConstraint());
    }

    /**
     * @test
     */
    public function notAcceptFloatUpperWithIncludeBound(): void {

        $constraint = new IsBetween(
            ['lower' => -1, 'upper' => 1, 'includeLowerBound' => true, 'includeUpperBound' => true]
        );

        $this->validator->validate(-1.1, $constraint);

        /** @var ConstraintViolation[] $violations */
        $violations = $this->validatorBuilder->getViolations();
        $this->assertCount(1, $violations);

        $this->assertEquals(-1.1, $violations[0]->getInvalidValue());
        $this->assertEmpty($violations[0]->getPropertyPath());
        $this->assertEquals(ErrorCodes::NOT_BETWEEN_ERROR()->value(), $violations[0]->getCode());
        $this->assertEquals($constraint, $violations[0]->getConstraint());
    }

    /**
     * @test
     */
    public function acceptIntBetween(): void {

        $this->validator->validate(0, $this->getConstraint());

        /** @var ConstraintViolation[] $violations */
        $violations = $this->validatorBuilder->getViolations();
        $this->assertCount(0, $violations);

    }

    /**
     * {@inheritDoc}
     */
    protected function getConstraint(): AbstractConstraint {

        return new IsBetween(['lower' => -1, 'upper' => 1]);
    }

    /**
     * @test
     */
    public function acceptFloatBetween(): void {

        $this->validator->validate(0.0, $this->getConstraint());

        /** @var ConstraintViolation[] $violations */
        $violations = $this->validatorBuilder->getViolations();
        $this->assertCount(0, $violations);
    }

    protected function getRequiredType(): string {
        return AbstractConstraintValidator::NUMBER;
    }

    /**
     * Get the types that are valid for the Validator
     *
     * @return array
     */
    protected function getValidTypes(): array {

        return [
            self::FLOAT,
            self::FLOAT_NEGATIVE,
            self::FLOAT_ZERO,
            self::FLOAT_POSITIVE,
            self::INT,
            self::INT_POSITIVE,
            self::INT_ZERO,
            self::INT_NEGATIVE,
            self::NUMBER_OR_STRING_FLOAT,
            self::NUMBER_OR_STRING_INT,
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected function getConstraintClass(): string {

        return IsBetween::class;
    }


}