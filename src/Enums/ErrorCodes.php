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

namespace FabianFroehlich\Validator\Enums;


use FabianFroehlich\Core\Util\Enum\AbstractEnum;

/**
 * Class ErrorCodes
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Enums
 *
 * @method static ErrorCodes MISSING_FIELD_ERROR()
 * @method static ErrorCodes NO_SUCH_FIELD_ERROR()
 * @method static ErrorCodes NOT_BOOLEAN_ERROR()
 * @method static ErrorCodes NOT_FALSE_ERROR()
 * @method static ErrorCodes NOT_FLOAT_ERROR()
 * @method static ErrorCodes NOT_GREATER_ERROR()
 * @method static ErrorCodes NOT_GREATER_OR_EQUAL_ERROR()
 * @method static ErrorCodes NOT_INTEGER_ERROR()
 * @method static ErrorCodes NOT_LOWER_ERROR()
 * @method static ErrorCodes NOT_LOWER_OR_EQUAL_ERROR()
 * @method static ErrorCodes IS_NULL_ERROR()
 * @method static ErrorCodes NOT_NULL_ERROR()
 * @method static ErrorCodes NOT_NUMBER_ERROR()
 * @method static ErrorCodes NOT_TRUE_ERROR()
 * @method static ErrorCodes NOT_ZERO_ERROR()
 * @method static ErrorCodes INVALID_VALUE_TYPE()
 * @method static ErrorCodes NOT_BETWEEN_ERROR()
 * @method static ErrorCodes NOT_ID_ERROR()
 * @method static ErrorCodes NOT_EQUAL_ERROR()
 * @method static ErrorCodes IS_EQUAL_ERROR()
 * @method static ErrorCodes NOT_EMAIL_ERROR()
 * @method static ErrorCodes EXPRESSION_NOT_MATCH_ERROR()
 * @method static ErrorCodes NOT_EQUAL_COUNT_ERROR()
 * @method static ErrorCodes NOT_IN_CHOICES()
 * @method static ErrorCodes NOT_DIVIDABLE_BY_ERROR()
 * @method static ErrorCodes ISBN_INVALID_LENGTH()
 * @method static ErrorCodes ISBN_INVALID_CHARS()
 * @method static ErrorCodes ISBN_INVALID_CHECKSUM()
 * @method static ErrorCodes PASSWORD_CONDITION_INVALID()
 * @method static ErrorCodes PASSWORD_COMPROMISED()
 * @method static ErrorCodes UUID_INVALID_VERSION()
 * @method static ErrorCodes UUID_INVALID_VARIANT()
 * @method static ErrorCodes UUID_INVALID_BLOCK()
 * @method static ErrorCodes UUID_GROUP_COUNT_INVALID()
 * @method static ErrorCodes UUID_INVALID_HYPHEN_POS()
 * @method static ErrorCodes UUID_INVALID_LENGTH()
 */
class ErrorCodes
    extends AbstractEnum {

    /** @const string */
    private const UUID_INVALID_VERSION = 'UUID_INVALID_VERSION';

    /** @const string */
    private const UUID_INVALID_VARIANT = 'UUID_INVALID_VARIANT';

    /** @const string */
    private const UUID_INVALID_BLOCK = 'UUID_INVALID_BLOCK';

    /** @const string */
    private const UUID_GROUP_COUNT_INVALID = 'UUID_GROUP_COUNT_INVALID';

    /** @const string */
    private const UUID_INVALID_HYPHEN_POS = 'UUID_INVALID_HYPHEN_POS';

    /** @const string */
    private const UUID_INVALID_LENGTH = 'UUID_INVALID_LENGTH';

    /** @const string */
    private const PASSWORD_CONDITION_INVALID = 'PASSWORD_CONDITION_INVALID';

    /** @const string */
    private const PASSWORD_COMPROMISED = 'PASSWORD_COMPROMISED';

    /** @const string */
    private const ISBN_INVALID_LENGTH = 'ISBN_INVALID_LENGTH';

    /** @const string */
    private const ISBN_INVALID_CHARS = 'ISBN_INVALID_CHARS';

    /** @const string */
    private const ISBN_INVALID_CHECKSUM = 'ISBN_INVALID_CHECKSUM';

    /** @const string */
    private const MISSING_FIELD_ERROR = 'MISSING_FIELD_ERROR';

    /** @const string */
    private const NO_SUCH_FIELD_ERROR = 'NO_SUCH_FIELD_ERROR';

    /** @const string */
    private const NOT_BOOLEAN_ERROR = 'NOT_BOOLEAN_ERROR';

    /** @const string */
    private const NOT_FALSE_ERROR = 'NOT_FALSE_ERROR';

    /** @const string */
    private const NOT_FLOAT_ERROR = 'NOT_FLOAT_ERROR';

    /** @const string */
    private const NOT_GREATER_ERROR = 'NOT_GREATER_ERROR';

    /** @const string */
    private const NOT_GREATER_OR_EQUAL_ERROR = 'NOT_GREATER_OR_EQUAL_ERROR';

    /** @const string */
    private const NOT_INTEGER_ERROR = 'NOT_INTEGER_ERROR';

    /** @const string */
    private const NOT_LOWER_ERROR = 'NOT_LOWER_ERROR';

    /** @const string */
    private const NOT_LOWER_OR_EQUAL_ERROR = 'NOT_LOWER_OR_EQUAL_ERROR';

    /** @const string */
    private const IS_NULL_ERROR = 'IS_NULL_ERROR';

    /** @const string */
    private const NOT_NULL_ERROR = 'NOT_NULL_ERROR';

    /** @const string */
    private const NOT_NUMBER_ERROR = 'NOT_NUMBER_ERROR';

    /** @const string */
    private const NOT_TRUE_ERROR = 'NOT_TRUE_ERROR';

    /** @const string */
    private const NOT_ZERO_ERROR = 'NOT_ZERO_ERROR';

    /** @const string */
    private const INVALID_VALUE_TYPE = 'INVALID_VALUE_TYPE';

    /** @const string */
    private const NOT_BETWEEN_ERROR = 'NOT_BETWEEN_ERROR';

    /** @const string */
    private const NOT_ID_ERROR = 'NOT_ID_ERROR';

    /** @const string */
    private const NOT_EQUAL_ERROR = 'NOT_EQUAL_ERROR';

    /** @const string */
    private const IS_EQUAL_ERROR = 'IS_EQUAL_ERROR';

    /** @const string */
    private const NOT_EMAIL_ERROR = 'NOT_EMAIL_ERROR';

    /** @const string */
    private const EXPRESSION_NOT_MATCH_ERROR = 'EXPRESSION_NOT_MATCH_ERROR';

    /** @const string */
    private const NOT_EQUAL_COUNT_ERROR = 'NOT_EQUAL_COUNT_ERROR';

    /** @const string */
    private const NOT_IN_CHOICES = 'NOT_IN_CHOICES';

    /** @const string */
    private const NOT_DIVIDABLE_BY_ERROR = 'NOT_DIVIDABLE_BY_ERROR';

}