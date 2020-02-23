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


use FabianFroehlich\Validator\Constraints\IsEmail;
use FabianFroehlich\Validator\Enums\ErrorCodes;
use FabianFroehlich\Validator\Tests\ValidatorTestCase;
use FabianFroehlich\Validator\Validator\AbstractConstraintValidator;
use FabianFroehlich\Validator\Violation\ConstraintViolation;

/**
 * Class IsEmailValidatorTest
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Tests\Validator\Integration
 */
class IsEmailValidatorTest
    extends ValidatorTestCase {

    /**
     * @test
     */
    public function willNotSucceedIfMailIsInvalid(): void {

        $invalidMails = file(
            __DIR__ . '/../../../vendor/f-froehlich/utils/Tests/Fixtures/invalidEmail.txt',
            FILE_IGNORE_NEW_LINES
        );

        foreach ($invalidMails as $invalidMail) {
            $this->validator->validate($invalidMail, $this->getConstraint());
        }

        /** @var ConstraintViolation[] $violations */
        $violations = $this->validatorBuilder->getViolations();
        $this->assertCount(count($invalidMails), $violations);

        foreach ($violations as $key => $violation) {
            $this->assertEquals($invalidMails[$key], $violation->getInvalidValue());
            $this->assertEmpty($violation->getPropertyPath());
            $this->assertEquals(ErrorCodes::NOT_EMAIL_ERROR()->value(), $violation->getCode());
            $this->assertEquals($this->getConstraint(), $violation->getConstraint());
        }

    }

    /**
     * @test
     */
    public function willSucceedIfValuesEquals(): void {

        $validEmails = file(
            __DIR__ . '/../../../vendor/f-froehlich/utils/Tests/Fixtures/validEmail.txt',
            FILE_IGNORE_NEW_LINES
        );

        foreach ($validEmails as $validEmail) {
            $this->validator->validate($validEmail, $this->getConstraint());
        }

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

        return IsEmail::class;
    }

}