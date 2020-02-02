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
use FabianFroehlich\Validator\Constraints\IsBetween;
use FabianFroehlich\Validator\Enums\ErrorCodes;

/**
 * Class IsBetweenValidator
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Validator
 */
class IsBetweenValidator
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

        return IsBetween::class;
    }

    /**
     * @param mixed     $value
     * @param IsBetween $constraint
     *
     * @return bool
     */
    protected function customValidation($value, AbstractConstraint $constraint): bool {

        $valid = true;
        if ($constraint->includeLowerBound) {
            if ($value < $constraint->lowerBound) {
                $this->addViolation($value, $constraint);
                $valid = false;
            }
        } else if ($value <= $constraint->lowerBound) {
            $this->addViolation($value, $constraint);
            $valid = false;
        }

        if ($constraint->includeUpperBound) {
            if ($value > $constraint->upperBound) {
                $this->addViolation($value, $constraint);
                $valid = false;
            }
        } else if ($value >= $constraint->upperBound) {
            $this->addViolation($value, $constraint);
            $valid = false;
        }

        return $valid;
    }

    /**
     * @param           $value
     * @param IsBetween $constraint
     */
    private function addViolation($value, IsBetween $constraint): void {
        $this->violationBuilder->addViolation(
            $value,
            ErrorCodes::NOT_BETWEEN_ERROR()->value(),
            ['lowerBound' => $constraint->lowerBound, 'upperBound' => $constraint->upperBound],
            $constraint
        );
    }
}
