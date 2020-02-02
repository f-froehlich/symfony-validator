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


use FabianFroehlich\Validator\Constraints\NotCompromisedPassword;
use FabianFroehlich\Validator\Enums\ErrorCodes;
use FabianFroehlich\Validator\Tests\ValidatorTestCase;
use FabianFroehlich\Validator\Validator\AbstractConstraintValidator;
use FabianFroehlich\Validator\Violation\ConstraintViolation;

/**
 * Class NotCompromisedPasswordValidatorTest
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Tests\Validator\Integration
 */
class NotCompromisedPasswordValidatorTest
    extends ValidatorTestCase {

    /**
     * @test
     */
    public function dontAcceptInvalidPasswords(): void {

        $invalidPasswords = $this->getInvalidPasswordSamples();

        foreach ($invalidPasswords as $invalidPassword) {
            $this->validator->validate($invalidPassword, $this->getConstraint());
        }

        /** @var ConstraintViolation[] $violations */
        $violations = $this->validatorBuilder->getViolations();
        $this->assertCount(count($invalidPasswords) * 2, $violations);

        $counter = -1;
        foreach ($violations as $violation) {
            $counter++;
            if (0 === $counter % 2) {
                // First is invalid password condition
                $this->assertEquals(ErrorCodes::PASSWORD_CONDITION_INVALID()->value(), $violation->getCode());
            } else {
                // second is leaked
                $this->assertEquals(ErrorCodes::PASSWORD_COMPROMISED()->value(), $violation->getCode());
                $this->assertEquals($this->getConstraint(), $violation->getConstraint());
            }
            $this->assertContains($violation->getInvalidValue(), $invalidPasswords);
            $this->assertContains($violation->getInvalidValue(), $invalidPasswords);
        }
    }

    private function getInvalidPasswordSamples(): array {

        return file(__DIR__ . '/../Fixtures/invalidPasswords.txt', FILE_IGNORE_NEW_LINES);
    }

    /**
     * @test
     */
    public function acceptValidPasswords(): void {

        $validPasswords = $this->getValidPasswordSamples();

        foreach ($validPasswords as $invalidPassword) {
            $this->validator->validate($invalidPassword, $this->getConstraint());
        }

        /** @var ConstraintViolation[] $violations */
        $violations = $this->validatorBuilder->getViolations();
        $this->assertCount(0, $violations);
    }

    private function getValidPasswordSamples(): array {

        return file(__DIR__ . '/../Fixtures/validPasswords.txt', FILE_IGNORE_NEW_LINES);

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

        return NotCompromisedPassword::class;
    }

}