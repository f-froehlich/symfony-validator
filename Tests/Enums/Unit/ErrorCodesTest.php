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

namespace FabianFroehlich\Validator\Tests\Enums\Unit;

use FabianFroehlich\Core\Util\Test\AbstractEnumValueEqualsKeyTestCase;
use FabianFroehlich\Validator\Enums\ErrorCodes;

/**
 * Class ErrorCodesTest
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Tests\Enums\Unit
 */
class ErrorCodesTest
    extends AbstractEnumValueEqualsKeyTestCase {

    protected function getEnumKeys(): array {
        return [
            'MISSING_FIELD_ERROR',
            'NO_SUCH_FIELD_ERROR',
            'NOT_BOOLEAN_ERROR',
            'NOT_FALSE_ERROR',
            'NOT_FLOAT_ERROR',
            'NOT_GREATER_ERROR',
            'NOT_GREATER_OR_EQUAL_ERROR',
            'NOT_INTEGER_ERROR',
            'NOT_LOWER_ERROR',
            'NOT_LOWER_OR_EQUAL_ERROR',
            'IS_NULL_ERROR',
            'NOT_NULL_ERROR',
            'NOT_NUMBER_ERROR',
            'NOT_TRUE_ERROR',
            'NOT_ZERO_ERROR',
            'INVALID_VALUE_TYPE',
            'NOT_BETWEEN_ERROR',
            'NOT_ID_ERROR',
            'NOT_EQUAL_ERROR',
            'IS_EQUAL_ERROR',
            'NOT_EMAIL_ERROR',
            'EXPRESSION_NOT_MATCH_ERROR',
            'NOT_EQUAL_COUNT_ERROR',
            'NOT_IN_CHOICES',
            'NOT_DIVIDABLE_BY_ERROR',
            'ISBN_INVALID_LENGTH',
            'ISBN_INVALID_CHARS',
            'ISBN_INVALID_CHECKSUM',
            'PASSWORD_COMPROMISED',
            'PASSWORD_CONDITION_INVALID',
            'UUID_INVALID_VERSION',
            'UUID_INVALID_VARIANT',
            'UUID_INVALID_BLOCK',
            'UUID_GROUP_COUNT_INVALID',
            'UUID_INVALID_HYPHEN_POS',
            'UUID_INVALID_LENGTH',
            'LOGICAL_XOR_INVALID',
        ];
    }

    protected function getEnumClass(): string {
        return ErrorCodes::class;
    }
}