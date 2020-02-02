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
use FabianFroehlich\Validator\Constraints\IsLowerThan;
use FabianFroehlich\Validator\Constraints\IsLowerThanOrEqual;
use FabianFroehlich\Validator\Enums\ErrorCodes;

/**
 * Class IsLowerThanOrEqualValidator
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Validator
 */
class IsLowerThanOrEqualValidator
    extends AbstractConstraintValidator {

    /**
     * {@inheritDoc}
     */
    public function getRequiredType(): string {

        return self::NUMBER;
    }

    /**
     * {@inheritDoc}
     */
    public function getRequiredConstraint(): string {

        return IsLowerThanOrEqual::class;
    }

    /**
     * @param             $value
     * @param IsLowerThan $constraint
     *
     * @return bool
     */
    protected function customValidation($value, AbstractConstraint $constraint): bool {

        if ($constraint->bound >= $value) {
            return true;
        }

        $this->violationBuilder->addViolation(
            $value,
            ErrorCodes::NOT_LOWER_OR_EQUAL_ERROR()->value(),
            ['bound' => $constraint->bound],
            $constraint
        );

        return false;
    }

}
