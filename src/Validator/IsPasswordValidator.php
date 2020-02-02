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

use FabianFroehlich\Core\Util\Enum\RegExp;
use FabianFroehlich\Validator\Constraints\AbstractConstraint;
use FabianFroehlich\Validator\Constraints\IsPassword;
use FabianFroehlich\Validator\Enums\ErrorCodes;

/**
 * Class IsPasswordValidator
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Validator
 */
class IsPasswordValidator
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

        return IsPassword::class;
    }

    /**
     * @param string     $value
     * @param IsPassword $constraint
     *
     * @return bool
     */
    protected function customValidation($value, AbstractConstraint $constraint): bool {

        if (1 === preg_match(RegExp::PASSWORD()->value(), $value)) {
            return true;
        }

        $this->violationBuilder->addViolation(
            $value,
            ErrorCodes::PASSWORD_CONDITION_INVALID()->value(),
            [],
            $constraint
        );

        return false;
    }

}
