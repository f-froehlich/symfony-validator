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

namespace FabianFroehlich\Validator\Validator;

use FabianFroehlich\Validator\Constraints\AbstractConstraint;
use FabianFroehlich\Validator\Constraints\IsISBN;
use FabianFroehlich\Validator\Enums\ErrorCodes;

/**
 * Class IsISBNValidator
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Validator
 */
class IsISBNValidator
    extends AbstractConstraintValidator {

    /**
     * {@inheritDoc}
     */
    public function getRequiredType(): string {

        return self::STRING;
    }

    /**
     * {@inheritDoc}
     */
    public function getRequiredConstraint(): string {

        return IsISBN::class;
    }

    /**
     * @param            $value
     * @param IsISBN     $constraint
     *
     * @return bool
     */
    protected function customValidation($value, AbstractConstraint $constraint): bool {

        $canonicalize = $this->canonicalize($value);

        $length = strlen($canonicalize);

        switch ($length) {
            case 10:
                return $this->validateIsbn10($canonicalize, $constraint);

            case 13:
                return $this->validateIsbn13($canonicalize, $constraint);
            default:
                $this->violationBuilder->addViolation(
                    $canonicalize,
                    ErrorCodes::ISBN_INVALID_LENGTH()->value(),
                    ['length' => $length],
                    $constraint
                );
                return false;

        }
    }

    protected function canonicalize(string $value): string {
        return str_replace([' ', '-'], '', $value);
    }

    /**
     * Validate ISBN-10
     *
     * @param string             $isbn must be canonicalize and length of 10
     * @param AbstractConstraint $constraint
     *
     * @return bool
     */
    protected function validateIsbn10(string $isbn, AbstractConstraint $constraint): bool {

        $checkSum = 0;
        $valid    = true;
        for ($charterPos = 0; $charterPos < 10; $charterPos++) {

            $charter = $isbn[$charterPos];

            if (ctype_digit($isbn[$charterPos])) {
                $checkSum += ((int)$charter) * (10 - $charterPos);
                continue;
            }
            if ('X' === $charter) {
                $checkSum += 10 * (10 - $charterPos);
                continue;
            }

            $valid = false;
            $this->violationBuilder->addViolation(
                $isbn,
                ErrorCodes::ISBN_INVALID_CHARS()->value(),
                ['char' => $charter],
                $constraint
            );
        }

        if ($valid && 0 !== $checkSum % 11) {
            $this->violationBuilder->addViolation(
                $isbn,
                ErrorCodes::ISBN_INVALID_CHECKSUM()->value(),
                ['checksum' => $checkSum % 11],
                $constraint
            );
        }

        return $valid;
    }

    /**
     * @param string             $isbn must be canonicalize and length of 13
     * @param AbstractConstraint $constraint
     *
     * @return bool
     */
    protected function validateIsbn13(string $isbn, AbstractConstraint $constraint): bool {

        if (!ctype_digit($isbn)) {
            $invalidChars = preg_replace('/\d/', '', $isbn);
            $length       = strlen($invalidChars);
            for ($i = 0; $i < $length; $i++) {
                $this->violationBuilder->addViolation(
                    $isbn,
                    ErrorCodes::ISBN_INVALID_CHARS()->value(),
                    ['char' => $invalidChars[$i]],
                    $constraint
                );
            }
            return false;
        }

        $checkSum = 0;
        for ($i = 0; $i < 13; $i += 2) {
            $checkSum += $isbn[$i];
        }

        for ($i = 1; $i < 12; $i += 2) {
            $checkSum += $isbn[$i] * 3;
        }

        if (0 !== $checkSum % 10) {
            $this->violationBuilder->addViolation(
                $isbn,
                ErrorCodes::ISBN_INVALID_CHECKSUM()->value(),
                ['checksum' => $checkSum % 10],
                $constraint
            );

            return false;
        }
        return true;
    }

}
