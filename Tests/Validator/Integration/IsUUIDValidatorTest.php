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


use FabianFroehlich\Validator\Constraints\IsUUID;
use FabianFroehlich\Validator\Enums\ErrorCodes;
use FabianFroehlich\Validator\Tests\ValidatorTestCase;
use FabianFroehlich\Validator\Validator\AbstractConstraintValidator;
use FabianFroehlich\Validator\Violation\ConstraintViolation;

/**
 * Class IsUUIDValidatorTest
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Tests\Validator\Integration
 */
class IsUUIDValidatorTest
    extends ValidatorTestCase {

    /**
     * @test
     */
    public function validateWithInvalidLength(): void {

        $this->validator->validate('short', $this->getConstraint());

        /** @var ConstraintViolation[] $violations */
        $violations = $this->validatorBuilder->getViolations();
        $this->assertCount(1, $violations);

        $this->assertEquals('short', $violations[0]->getInvalidValue());
        $this->assertEmpty($violations[0]->getPropertyPath());
        $this->assertEquals(ErrorCodes::UUID_INVALID_LENGTH()->value(), $violations[0]->getCode());
        $this->assertEquals($this->getConstraint(), $violations[0]->getConstraint());
    }

    /**
     * @test
     */
    public function validateHyphenPositionMissmatch(): void {

        $this->validator->validate('xxxxxxxx xxxx xxxx xxxx xxxxxxxxxxxx', $this->getConstraint());

        /** @var ConstraintViolation[] $violations */
        $violations = $this->validatorBuilder->getViolations();
        $this->assertCount(4, $violations);

        foreach ($violations as $violation) {
            $this->assertEquals('xxxxxxxx xxxx xxxx xxxx xxxxxxxxxxxx', $violation->getInvalidValue());
            $this->assertEmpty($violation->getPropertyPath());
            $this->assertEquals(ErrorCodes::UUID_INVALID_HYPHEN_POS()->value(), $violation->getCode());
            $this->assertEquals($this->getConstraint(), $violation->getConstraint());
        }
    }

    /**
     * @test
     */
    public function validateMoreThan5Hyphens(): void {

        $this->validator->validate('-xxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx', $this->getConstraint());

        /** @var ConstraintViolation[] $violations */
        $violations = $this->validatorBuilder->getViolations();
        $this->assertCount(1, $violations);

        foreach ($violations as $violation) {
            $this->assertEquals('-xxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx', $violation->getInvalidValue());
            $this->assertEmpty($violation->getPropertyPath());
            $this->assertEquals(ErrorCodes::UUID_GROUP_COUNT_INVALID()->value(), $violation->getCode());
            $this->assertEquals($this->getConstraint(), $violation->getConstraint());
        }
    }

    /**
     * @test
     */
    public function validateGroup1(): void {

        $this->validator->validate('xxxxxxxx-0000-1000-1000-000000000000', $this->getConstraint());

        /** @var ConstraintViolation[] $violations */
        $violations = $this->validatorBuilder->getViolations();
        $this->assertCount(1, $violations);

        foreach ($violations as $violation) {
            $this->assertEquals('xxxxxxxx-0000-1000-1000-000000000000', $violation->getInvalidValue());
            $this->assertEmpty($violation->getPropertyPath());
            $this->assertEquals(ErrorCodes::UUID_INVALID_BLOCK()->value(), $violation->getCode());
            $this->assertEquals($this->getConstraint(), $violation->getConstraint());
        }
    }

    /**
     * @test
     */
    public function validateGroup2(): void {

        $this->validator->validate('00000000-x000-1000-1000-000000000000', $this->getConstraint());

        /** @var ConstraintViolation[] $violations */
        $violations = $this->validatorBuilder->getViolations();
        $this->assertCount(1, $violations);

        foreach ($violations as $violation) {
            $this->assertEquals('00000000-x000-1000-1000-000000000000', $violation->getInvalidValue());
            $this->assertEmpty($violation->getPropertyPath());
            $this->assertEquals(ErrorCodes::UUID_INVALID_BLOCK()->value(), $violation->getCode());
            $this->assertEquals($this->getConstraint(), $violation->getConstraint());
        }
    }

    /**
     * @test
     */
    public function validateGroup3(): void {

        $this->validator->validate('00000000-0000-100x-1000-000000000000', $this->getConstraint());

        /** @var ConstraintViolation[] $violations */
        $violations = $this->validatorBuilder->getViolations();
        $this->assertCount(1, $violations);

        foreach ($violations as $violation) {
            $this->assertEquals('00000000-0000-100x-1000-000000000000', $violation->getInvalidValue());
            $this->assertEmpty($violation->getPropertyPath());
            $this->assertEquals(ErrorCodes::UUID_INVALID_BLOCK()->value(), $violation->getCode());
            $this->assertEquals($this->getConstraint(), $violation->getConstraint());
        }
    }

    /**
     * @test
     */
    public function validateGroup4(): void {

        $this->validator->validate('00000000-0000-1000-100x-000000000000', $this->getConstraint());

        /** @var ConstraintViolation[] $violations */
        $violations = $this->validatorBuilder->getViolations();
        $this->assertCount(1, $violations);

        foreach ($violations as $violation) {
            $this->assertEquals('00000000-0000-1000-100x-000000000000', $violation->getInvalidValue());
            $this->assertEmpty($violation->getPropertyPath());
            $this->assertEquals(ErrorCodes::UUID_INVALID_BLOCK()->value(), $violation->getCode());
            $this->assertEquals($this->getConstraint(), $violation->getConstraint());
        }
    }

    /**
     * @test
     */
    public function validateGroup5(): void {

        $this->validator->validate('00000000-0000-1000-1000-x00000000000', $this->getConstraint());

        /** @var ConstraintViolation[] $violations */
        $violations = $this->validatorBuilder->getViolations();
        $this->assertCount(1, $violations);

        foreach ($violations as $violation) {
            $this->assertEquals('00000000-0000-1000-1000-x00000000000', $violation->getInvalidValue());
            $this->assertEmpty($violation->getPropertyPath());
            $this->assertEquals(ErrorCodes::UUID_INVALID_BLOCK()->value(), $violation->getCode());
            $this->assertEquals($this->getConstraint(), $violation->getConstraint());
        }
    }

    /**
     * @test
     */
    public function validateInvalidVersion(): void {

        $this->validator->validate('00000000-0000-5000-1000-000000000000', $this->getConstraint());

        /** @var ConstraintViolation[] $violations */
        $violations = $this->validatorBuilder->getViolations();
        $this->assertCount(1, $violations);

        foreach ($violations as $violation) {
            $this->assertEquals('00000000-0000-5000-1000-000000000000', $violation->getInvalidValue());
            $this->assertEmpty($violation->getPropertyPath());
            $this->assertEquals(ErrorCodes::UUID_INVALID_VERSION()->value(), $violation->getCode());
            $this->assertEquals($this->getConstraint(), $violation->getConstraint());
        }
    }

    /**
     * @test
     */
    public function validateValidVersion(): void {

        $this->validator->validate('00000000-0000-1000-1000-000000000000', $this->getConstraint());
        $this->validator->validate('00000000-0000-2000-1000-000000000000', $this->getConstraint());
        $this->validator->validate('00000000-0000-3000-1000-000000000000', $this->getConstraint());
        $this->validator->validate('00000000-0000-4000-1000-000000000000', $this->getConstraint());

        /** @var ConstraintViolation[] $violations */
        $violations = $this->validatorBuilder->getViolations();
        $this->assertCount(0, $violations);

    }

    /**
     * @test
     */
    public function validateInvalidVariant(): void {

        $this->validator->validate('00000000-0000-1000-4000-000000000000', $this->getConstraint());

        /** @var ConstraintViolation[] $violations */
        $violations = $this->validatorBuilder->getViolations();
        $this->assertCount(1, $violations);

        foreach ($violations as $violation) {
            $this->assertEquals('00000000-0000-1000-4000-000000000000', $violation->getInvalidValue());
            $this->assertEmpty($violation->getPropertyPath());
            $this->assertEquals(ErrorCodes::UUID_INVALID_VARIANT()->value(), $violation->getCode());
            $this->assertEquals($this->getConstraint(), $violation->getConstraint());
        }
    }

    /**
     * @test
     */
    public function validateValidVariant(): void {

        $this->validator->validate('00000000-0000-1000-1000-000000000000', $this->getConstraint());
        $this->validator->validate('00000000-0000-1000-2000-000000000000', $this->getConstraint());
        $this->validator->validate('00000000-0000-1000-3000-000000000000', $this->getConstraint());

        /** @var ConstraintViolation[] $violations */
        $violations = $this->validatorBuilder->getViolations();
        $this->assertCount(0, $violations);

    }

    protected function getRequiredType(): string {
        return AbstractConstraintValidator::STRING;
    }

    /**
     * Get the types that are valid for the Validator
     *
     * @return array
     */
    protected function getValidTypes(): array {

        return [self::STRING, self::NUMBER_OR_STRING_STRING];
    }

    /**
     * {@inheritDoc}
     */
    protected function getConstraintClass(): string {

        return IsUUID::class;
    }

}