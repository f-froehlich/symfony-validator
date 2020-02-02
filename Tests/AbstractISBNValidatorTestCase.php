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

namespace FabianFroehlich\Validator\Tests;


use FabianFroehlich\Validator\Enums\ErrorCodes;
use FabianFroehlich\Validator\Validator\AbstractConstraintValidator;

/**
 * Class AbstractISBNValidatorTestCase
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Tests
 */
abstract class AbstractISBNValidatorTestCase
    extends ValidatorTestCase {

    public function checkValidIsbn10(): void {
        $constraint = $this->getConstraint();
        foreach ($this->getValidIsbn10() as $isbn) {
            $this->validator->validate($isbn, $constraint);
        }

        $this->assertCount(0, $this->validatorBuilder->getViolations());
    }

    protected function getValidIsbn10(): array {
        return [
            '99921-58-10-7',
            '9971-5-0210-0',
            '960-425-059-0',
            '80-902734-1-6',
            '85-359-0277-5',
            '1-84356-028-3',
            '0-684-84328-5',
            '0-8044-2957-X',
            '0 85131-041-9', // one - are space
            '93 86954 21 4', // all - are spaces
            '0943396-04-2', // one - missing
            '097522980X', // all - missing
        ];
    }

    public function checkInvalidIsbn10(): void {
        $constraint = $this->getConstraint();
        foreach ($this->getInvalidIsbn10() as $isbn => $error) {
            $this->validator->validate($isbn, $constraint);
        }

        $violations = $this->validatorBuilder->getViolations();
        $this->assertCount(count($this->getInvalidIsbn10()), $violations);

        $i = 0;
        foreach ($this->getInvalidIsbn10() as $isbn => $error) {

            if (0 === $i) {
                $this->assertEquals(ErrorCodes::ISBN_INVALID_CHARS()->value(), $violations[$i]->getCode());
            } else {
                $this->assertEquals(ErrorCodes::ISBN_INVALID_CHECKSUM()->value(), $violations[$i]->getCode());
            }
            $this->assertEquals($constraint, $violations[1]->getConstraint());
            $this->assertEquals(str_replace([' ', '-'], '', $isbn), $violations[$i]->getInvalidValue());
            $this->assertEmpty($violations[$i]->getPropertyPath());
            $i++;
        }
    }

    protected function getInvalidIsbn10(): array {
        return [
            '99921-58-10-B' => ['invalidCharter' => 'B'],
            '9971-5-0210-1' => ['invalidChecksum' => 0],
            '960-425-059-X' => ['invalidChecksum' => 0],
            '0 85131-041-8' => ['invalidChecksum' => 9],
            '93 86954 21 6' => ['invalidChecksum' => 5],
            '0943396-04-3'  => ['invalidChecksum' => 2],
            '0975229809'    => ['invalidChecksum' => 10],
        ];
    }

    public function checkValidIsbn13(): void {
        $constraint = $this->getConstraint();
        foreach ($this->getValidIsbn13() as $isbn) {
            $this->validator->validate($isbn, $constraint);
        }

        $this->assertCount(0, $this->validatorBuilder->getViolations());
    }

    protected function getValidIsbn13(): array {
        return [
            '978-1-86197-876-9',
            '5060004769643',
            '9780136091813',
            '9783880530751',
            '978-2723442282',
            '978-2723442275',
            '978-2723455046',
            '978-2070546817',
            '978-2711858835',
            '978-2756406763',
            '978-2870971642',
            '978-2266238540',
            '978-2851806420',
            '978-0321812704',
            '978-0451225245',
            '978-0471292319',
        ];
    }

    public function checkInvalidIsbn13(): void {
        $constraint = $this->getConstraint();
        foreach ($this->getInvalidIsbn13() as $isbn) {
            $this->validator->validate($isbn, $constraint);
        }

        $violations = $this->validatorBuilder->getViolations();
        $this->assertCount(count($this->getInvalidIsbn13()), $violations);

        $i = 0;
        foreach ($this->getInvalidIsbn13() as $isbn) {

            if (0 === $i) {
                $this->assertEquals(ErrorCodes::ISBN_INVALID_CHARS()->value(), $violations[$i]->getCode());
            } else {
                $this->assertEquals(ErrorCodes::ISBN_INVALID_CHECKSUM()->value(), $violations[$i]->getCode());
            }
            $this->assertEquals($constraint, $violations[1]->getConstraint());
            $this->assertEquals(str_replace([' ', '-'], '', $isbn), $violations[$i]->getInvalidValue());
            $this->assertEmpty($violations[$i]->getPropertyPath());
            $i++;
        }
    }

    protected function getInvalidIsbn13(): array {
        return [
            '978-1-86197-876-B',
            '5060004769644',
            '9780136091814',
            '9783880530752',
            '978-2723442283',
            '978-2723442276',
            '978-2723455047',
            '978-2070546818',
            '978-2711858836',
            '978-2756406764',
            '978-2870971643',
            '978-2266238541',
            '978-2851806421',
            '978-0321812705',
            '978-0451225246',
            '978-0471292310',
        ];
    }

    /**
     * @test
     */
    public function checkInvalidLength(): void {
        $this->checkLength($this->getInvalidIsbnLength());
    }

    protected function checkLength(array $invalidValues): void {
        $constraint = $this->getConstraint();
        foreach ($invalidValues as $invalidValue) {
            $this->validator->validate($invalidValue, $constraint);
        }

        $violations = $this->validatorBuilder->getViolations();
        $this->assertCount(count($invalidValues), $violations);

        $i = 0;
        foreach ($invalidValues as $invalidValue) {

            $this->assertEquals(ErrorCodes::ISBN_INVALID_LENGTH()->value(), $violations[$i]->getCode());
            $this->assertEquals($constraint, $violations[1]->getConstraint());
            $this->assertEquals(str_replace([' ', '-'], '', $invalidValue), $violations[$i]->getInvalidValue());
            $this->assertEmpty($violations[$i]->getPropertyPath());
            $i++;
        }
    }

    protected function getInvalidIsbnLength(): array {
        return array_intersect($this->getInvalidIsbn10Length(), $this->getInvalidIsbn13Length());
    }

    protected function getInvalidIsbn10Length(): array {
        return [
            '1',
            '12',
            '123',
            '1234',
            '12345',
            '123456',
            '1234567',
            '12345678',
            '123456789',
            '12345678911',
            '123456789112',
            '1234567891123',
            '12345678911234',
            '123456789112345',
        ];
    }

    protected function getInvalidIsbn13Length(): array {
        return [
            '1',
            '12',
            '123',
            '1234',
            '12345',
            '123456',
            '1234567',
            '12345678',
            '123456789',
            '1234567890',
            '12345678911',
            '123456789112',
            '12345678911234',
            '123456789112345',
        ];
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

}