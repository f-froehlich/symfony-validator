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
use FabianFroehlich\Validator\Constraints\IsDividableBy;
use FabianFroehlich\Validator\Enums\ErrorCodes;
use FabianFroehlich\Validator\Tests\ValidatorTestCase;
use FabianFroehlich\Validator\Validator\AbstractConstraintValidator;
use FabianFroehlich\Validator\Violation\ConstraintViolation;

/**
 * Class IsDividableByValidatorTest
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Tests\Validator\Integration
 */
class IsDividableByValidatorTest
    extends ValidatorTestCase {

    /**
     * @test
     */
    public function willNotSucceedIfValueNotDividable(): void {

        $this->validator->validate(1, $this->getConstraint());

        /** @var ConstraintViolation[] $violations */
        $violations = $this->validatorBuilder->getViolations();
        $this->assertCount(1, $violations);

        $this->assertEquals(1, $violations[0]->getInvalidValue());
        $this->assertEmpty($violations[0]->getPropertyPath());
        $this->assertEquals(ErrorCodes::NOT_DIVIDABLE_BY_ERROR()->value(), $violations[0]->getCode());
        $this->assertEquals($this->getConstraint(), $violations[0]->getConstraint());
    }

    /**
     * {@inheritDoc}
     */
    protected function getConstraint(): AbstractConstraint {


        return new IsDividableBy(3);
    }

    /**
     * @test
     */
    public function willSucceedIfValueDividable(): void {

        $this->validator->validate(3, $this->getConstraint());
        $this->validator->validate(6.0, $this->getConstraint());
        $this->validator->validate(-9, $this->getConstraint());

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

        return IsDividableBy::class;
    }

}