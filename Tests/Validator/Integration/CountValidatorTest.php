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
use FabianFroehlich\Validator\Constraints\Count;
use FabianFroehlich\Validator\Enums\ErrorCodes;
use FabianFroehlich\Validator\Tests\ValidatorTestCase;
use FabianFroehlich\Validator\Validator\AbstractConstraintValidator;
use FabianFroehlich\Validator\Violation\ConstraintViolation;

/**
 * Class CountValidatorTest
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Tests\Validator\Integration
 */
class CountValidatorTest
    extends ValidatorTestCase {

    /**
     * @test
     */
    public function willAddViolationIfCountNotMatch(): void {

        $arr = [1, 2, 3];
        $this->validator->validate($arr, $this->getConstraint());

        /** @var ConstraintViolation[] $violations */
        $violations = $this->validatorBuilder->getViolations();
        $this->assertCount(1, $violations);

        $this->assertEquals($arr, $violations[0]->getInvalidValue());
        $this->assertEmpty($violations[0]->getPropertyPath());
        $this->assertEquals(ErrorCodes::NOT_EQUAL_COUNT_ERROR()->value(), $violations[0]->getCode());
        $this->assertEquals($this->getConstraint(), $violations[0]->getConstraint());
    }

    /**
     * {@inheritDoc}
     */
    protected function getConstraint(): AbstractConstraint {

        $class = $this->getConstraintClass();

        return new $class(0);
    }

    /**
     * {@inheritDoc}
     */
    protected function getConstraintClass(): string {

        return Count::class;
    }

    /**
     * @test
     */
    public function willPassIfCountMatch(): void {

        $arr = [];
        $this->validator->validate($arr, $this->getConstraint());

        /** @var ConstraintViolation[] $violations */
        $violations = $this->validatorBuilder->getViolations();
        $this->assertCount(0, $violations);

    }

    protected function getRequiredType(): string {
        return AbstractConstraintValidator::LIST;
    }

    /**
     * Get the types that are valid for the Validator
     *
     * @return array
     */
    protected function getValidTypes(): array {

        return [self::ARRAY];
    }


}