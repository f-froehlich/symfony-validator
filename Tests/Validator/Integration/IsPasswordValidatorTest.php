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


use FabianFroehlich\Validator\Constraints\IsPassword;
use FabianFroehlich\Validator\Enums\ErrorCodes;
use FabianFroehlich\Validator\Tests\ValidatorTestCase;
use FabianFroehlich\Validator\Validator\AbstractConstraintValidator;

/**
 * Class IsPasswordValidatorTest
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Tests\Validator\Integration
 */
class IsPasswordValidatorTest
    extends ValidatorTestCase {


    /**
     * @test
     */
    public function validPasswordWillAccepted(): void {

        $validPasswords = file(
            __DIR__ . '/../../../vendor/f-froehlich/utils/Tests/Fixtures/validPasswords.txt',
            FILE_IGNORE_NEW_LINES
        );

        foreach ($validPasswords as $validPassword) {
            $this->validator->validate($validPassword, $this->getConstraint());
        }
        $violations = $this->validatorBuilder->getViolations();
        $this->assertCount(0, $violations);
    }

    /**
     * @test
     */
    public function invalidPasswordWillNotAccepted(): void {

        $invalidPasswords = file(
            __DIR__ . '/../../../vendor/f-froehlich/utils/Tests/Fixtures/invalidPasswords.txt',
            FILE_IGNORE_NEW_LINES
        );

        foreach ($invalidPasswords as $invalidPassword) {
            $this->validator->validate($invalidPassword, $this->getConstraint());
        }

        $violations = $this->validatorBuilder->getViolations();
        $this->assertCount(count($invalidPasswords), $violations);

        foreach ($violations as $violation) {
            $this->assertContains($violation->getInvalidValue(), $invalidPasswords);
            $this->assertEmpty($violation->getPropertyPath());
            $this->assertEquals(ErrorCodes::PASSWORD_CONDITION_INVALID()->value(), $violation->getCode());
            $this->assertEquals($this->getConstraint(), $violation->getConstraint());
        }
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

        return IsPassword::class;
    }

}