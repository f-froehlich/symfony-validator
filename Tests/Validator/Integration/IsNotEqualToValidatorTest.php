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
use FabianFroehlich\Validator\Constraints\IsNotEqualTo;
use FabianFroehlich\Validator\Enums\ErrorCodes;
use FabianFroehlich\Validator\Tests\ValidatorTestCase;
use FabianFroehlich\Validator\Validator\AbstractConstraintValidator;
use FabianFroehlich\Validator\Violation\ConstraintViolation;

/**
 * Class IsNotEqualToValidatorTest
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Tests\Validator\Integration
 */
class IsNotEqualToValidatorTest
    extends ValidatorTestCase {

    /**
     * @test
     */
    public function willNotSucceedIfValuesEquals(): void {

        $this->validator->validate('value', $this->getConstraint());

        /** @var ConstraintViolation[] $violations */
        $violations = $this->validatorBuilder->getViolations();
        $this->assertCount(1, $violations);

        $this->assertEquals('value', $violations[0]->getInvalidValue());
        $this->assertEmpty($violations[0]->getPropertyPath());
        $this->assertEquals(ErrorCodes::IS_EQUAL_ERROR()->value(), $violations[0]->getCode());
        $this->assertEquals($this->getConstraint(), $violations[0]->getConstraint());
    }

    /**
     * {@inheritDoc}
     */
    protected function getConstraint(): AbstractConstraint {


        return new IsNotEqualTo('value');
    }

    /**
     * @test
     */
    public function willSucceedIfValuesEquals(): void {

        $this->validator->validate('other', $this->getConstraint());

        /** @var ConstraintViolation[] $violations */
        $violations = $this->validatorBuilder->getViolations();
        $this->assertCount(0, $violations);
    }

    protected function getRequiredType(): string {
        return AbstractConstraintValidator::ALL;
    }

    /**
     * Get the types that are valid for the Validator
     *
     * @return array
     */
    protected function getValidTypes(): array {

        return $this->getAllTypes();
    }

    /**
     * {@inheritDoc}
     */
    protected function getConstraintClass(): string {

        return IsNotEqualTo::class;
    }

}