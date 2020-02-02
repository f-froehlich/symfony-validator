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
use FabianFroehlich\Validator\Constraints\Collection;
use FabianFroehlich\Validator\Constraints\IsBool;
use FabianFroehlich\Validator\Constraints\IsFalse;
use FabianFroehlich\Validator\Constraints\IsOptional;
use FabianFroehlich\Validator\Enums\ErrorCodes;
use FabianFroehlich\Validator\Tests\ValidatorTestCase;
use FabianFroehlich\Validator\Validator\AbstractConstraintValidator;
use FabianFroehlich\Validator\Violation\ConstraintViolation;

/**
 * Class CollectionValidatorTest
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Tests\Validator\Integration
 */
class CollectionValidatorTest
    extends ValidatorTestCase {

    /**
     * @test
     */
    public function checkCollectionCorrectWithoutRecursion(): void {

        $constraint = $this->initConstraint(
            [
                'boolean'   => new IsBool(),
                'optional1' => new IsOptional(new IsBool()),
                'optional2' => new IsOptional(new IsFalse()),
            ]
        );

        $this->validator->validate(['boolean' => true, 'optional2' => false], $constraint);
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

        return Collection::class;
    }

    /**
     * @test
     */
    public function checkCollectionCorrectWithRecursion(): void {

        $bool                = new IsBool();
        $recursiveCollection = New Collection(
            [
                'true'    => new IsBool(),
                'missing' => $bool,
            ]
        );
        $constraint          = $this->initConstraint(
            [
                'boolean'   => new IsBool(),
                'recursion' => $recursiveCollection,
            ]
        );

        $this->validator->validate(
            [
                'boolean'   => true,
                'recursion' => [
                    'true'       => true,
                    'extraField' => 'extraField',
                ],
            ]
            ,
            $constraint
        );
        /** @var ConstraintViolation[] $violations */
        $violations = $this->validatorBuilder->getViolations();
        $this->assertCount(2, $violations);

        $this->assertNull($violations[0]->getInvalidValue());
        $this->assertEquals('/recursion/missing', $violations[0]->getPropertyPath());
        $this->assertEquals(ErrorCodes::MISSING_FIELD_ERROR()->value(), $violations[0]->getCode());
        $this->assertEquals($bool, $violations[0]->getConstraint());

        $this->assertEquals('extraField', $violations[1]->getInvalidValue());
        $this->assertEquals('/recursion/extraField', $violations[1]->getPropertyPath());
        $this->assertEquals(ErrorCodes::NO_SUCH_FIELD_ERROR()->value(), $violations[1]->getCode());
        $this->assertEquals($recursiveCollection, $violations[1]->getConstraint());

    }

    /**
     * @test
     */
    public function checkCollectionWithMissingField(): void {

        $bool       = new IsBool();
        $constraint = $this->initConstraint(
            [
                'boolean' => $bool,
            ]
        );

        $this->validator->validate([], $constraint);
        /** @var ConstraintViolation[] $violations */
        $violations = $this->validatorBuilder->getViolations();
        $this->assertCount(1, $violations);

        $this->assertNull($violations[0]->getInvalidValue());
        $this->assertEquals('/boolean', $violations[0]->getPropertyPath());
        $this->assertEquals(ErrorCodes::MISSING_FIELD_ERROR()->value(), $violations[0]->getCode());
        $this->assertEquals($bool, $violations[0]->getConstraint());
    }

    /**
     * @test
     */
    public function checkCollectionWithExtraField(): void {

        $bool       = new IsBool();
        $constraint = $this->initConstraint(
            [
                'boolean' => $bool,
            ]
        );

        $this->validator->validate(['boolean' => true, 'extraField' => 'extraField'], $constraint);
        /** @var ConstraintViolation[] $violations */
        $violations = $this->validatorBuilder->getViolations();
        $this->assertCount(1, $violations);

        $this->assertEquals('extraField', $violations[0]->getInvalidValue());
        $this->assertEquals('/extraField', $violations[0]->getPropertyPath());
        $this->assertEquals(ErrorCodes::NO_SUCH_FIELD_ERROR()->value(), $violations[0]->getCode());
        $this->assertEquals($constraint, $violations[0]->getConstraint());
    }

    protected function getRequiredType(): string {
        return AbstractConstraintValidator::LIST;
    }

    /**
     * {@inheritDoc}
     */
    protected function getConstraint(): AbstractConstraint {

        return $this->initConstraint([]);
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