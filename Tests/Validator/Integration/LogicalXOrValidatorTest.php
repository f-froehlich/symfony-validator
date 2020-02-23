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
use FabianFroehlich\Validator\Constraints\IsNotNull;
use FabianFroehlich\Validator\Constraints\IsNull;
use FabianFroehlich\Validator\Constraints\LogicalXOr;
use FabianFroehlich\Validator\Enums\ErrorCodes;
use FabianFroehlich\Validator\Tests\ValidatorTestCase;
use FabianFroehlich\Validator\Validator\AbstractConstraintValidator;

/**
 * Class LogicalXOrValidatorTest
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Tests\Validator\Integration
 */
class LogicalXOrValidatorTest
    extends ValidatorTestCase {

    /**
     * @test
     */
    public function checkBothValuesValid(): void {
        $constraint = new LogicalXOr(['left' => new IsNull(), 'right' => new IsNull()]);

        $this->assertFalse($this->validator->validate(null, $constraint));

        $this->assertCount(1, $this->validatorBuilder->getViolations());
        $violation = $this->validatorBuilder->getViolations()[0];
        $this->assertEquals(ErrorCodes::LOGICAL_XOR_INVALID()->value(), $violation->getCode());

    }

    /**
     * @test
     */
    public function passIfLeftValueIsValid(): void {
        $constraint = new LogicalXOr(['left' => new IsNull(), 'right' => new IsNotNull()]);

        $this->assertTrue($this->validator->validate(null, $constraint));
    }

    /**
     * @test
     */
    public function passIfRightValueIsPassed(): void {
        $constraint = new LogicalXOr(['left' => new IsNotNull(), 'right' => new IsNull()]);

        $this->assertTrue($this->validator->validate(null, $constraint));
    }

    /**
     * @test
     */
    public function failIfBothValueIsInvalid(): void {
        $constraint = new LogicalXOr(['left' => new IsNotNull(), 'right' => new IsNotNull()]);

        $this->assertFalse($this->validator->validate(null, $constraint));

        $this->assertCount(3, $this->validatorBuilder->getViolations());
        $violation = $this->validatorBuilder->getViolations()[2];
        $this->assertEquals(ErrorCodes::LOGICAL_XOR_INVALID()->value(), $violation->getCode());
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
    protected function getConstraint(): AbstractConstraint {

        $class = $this->getConstraintClass();

        return new $class(['left' => new IsNotNull(), 'right' => new IsNotNull()]);
    }

    /**
     * {@inheritDoc}
     */
    protected function getConstraintClass(): string {

        return LogicalXOr::class;
    }

}