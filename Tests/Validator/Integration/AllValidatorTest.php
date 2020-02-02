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
use FabianFroehlich\Validator\Constraints\All;
use FabianFroehlich\Validator\Constraints\Collection;
use FabianFroehlich\Validator\Constraints\IsFalse;
use FabianFroehlich\Validator\Constraints\IsTrue;
use FabianFroehlich\Validator\Enums\ErrorCodes;
use FabianFroehlich\Validator\Tests\ValidatorTestCase;
use FabianFroehlich\Validator\Validator\AbstractConstraintValidator;
use FabianFroehlich\Validator\Violation\ConstraintViolation;

/**
 * Class AllValidatorTest
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Tests\Validator\Integration
 */
class AllValidatorTest
    extends ValidatorTestCase {

    /**
     * @test
     */
    public function checkEmptyCollection(): void {

        $true  = new IsTrue();
        $false = new IsFalse();

        $constraint = $this->initConstraint(
            new Collection(
                [
                    'true'  => $true,
                    'false' => $false,
                ]
            )
        );

        $this->validator->validate(
            [],
            $constraint
        );

        $this->assertCount(0, $this->validatorBuilder->getViolations());
    }

    private function initConstraint($options): AbstractConstraint {

        $class = $this->getConstraintClass();

        return new $class($options);
    }

    /**
     * {@inheritDoc}
     */
    protected function getConstraintClass(): string {

        return All::class;
    }

    /**
     * @test
     */
    public function checkCollectionWithValidValues(): void {

        $true  = new IsTrue();
        $false = new IsFalse();

        $constraint = $this->initConstraint(
            new Collection(
                [
                    'true'  => $true,
                    'false' => $false,
                ]
            )
        );

        $this->validator->validate(
            [
                ['true' => true, 'false' => false],
                ['true' => true, 'false' => false],
                ['true' => true, 'false' => false],
            ],
            $constraint
        );

        $this->assertCount(0, $this->validatorBuilder->getViolations());
    }

    /**
     * @test
     */
    public function checkCollectionWithInvalidValues(): void {

        $true  = new IsTrue();
        $false = new IsFalse();

        $constraint = $this->initConstraint(
            new Collection(
                [
                    'true'  => $true,
                    'false' => $false,
                ]
            )
        );

        $this->validator->validate(
            [
                ['true' => true, 'false' => false],
                ['true' => false, 'false' => false],
                ['true' => true, 'false' => true],
            ],
            $constraint
        );


        /** @var ConstraintViolation[] $violations */
        $violations = $this->validatorBuilder->getViolations();
        $this->assertCount(2, $violations);

        $this->assertFalse($violations[0]->getInvalidValue());
        $this->assertEquals('/[1]/true', $violations[0]->getPropertyPath());
        $this->assertEquals(ErrorCodes::NOT_TRUE_ERROR()->value(), $violations[0]->getCode());
        $this->assertEquals($true, $violations[0]->getConstraint());

        $this->assertTrue($violations[1]->getInvalidValue());
        $this->assertEquals('/[2]/false', $violations[1]->getPropertyPath());
        $this->assertEquals(ErrorCodes::NOT_FALSE_ERROR()->value(), $violations[1]->getCode());
        $this->assertEquals($false, $violations[1]->getConstraint());
    }

    protected function getRequiredType(): string {
        return AbstractConstraintValidator::LIST;
    }

    /**
     * {@inheritDoc}
     */
    protected function getConstraint(): AbstractConstraint {

        return $this->initConstraint(new Collection());
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