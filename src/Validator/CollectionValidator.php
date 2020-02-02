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

use ArrayAccess;
use FabianFroehlich\Validator\Constraints\AbstractConstraint;
use FabianFroehlich\Validator\Constraints\Collection;
use FabianFroehlich\Validator\Constraints\IsOptional;
use FabianFroehlich\Validator\Enums\ErrorCodes;
use function array_key_exists;
use function is_array;

/**
 * Class CollectionValidator
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Validator
 */
class CollectionValidator
    extends AbstractConstraintValidator {

    public function getRequiredType(): string {

        return self::LIST;
    }

    public function getRequiredConstraint(): string {

        return Collection::class;
    }

    /**
     * @param mixed      $value
     * @param Collection $constraint
     *
     * @return bool
     */
    protected function customValidation($value, AbstractConstraint $constraint): bool {

        $mainPath = $this->violationBuilder->getPath();
        $valid    = true;
        foreach ($constraint->fields as $field => $fieldConstraint) {
            $this->violationBuilder->setPath($mainPath . '/' . $field);

            $existsInArray = (is_array($value) && array_key_exists($field, $value))
                             || ($value instanceof ArrayAccess && $value->offsetExists($field));

            if ($existsInArray) {
                $valid = $this->violationBuilder
                             ->validateValue($value[$field], $fieldConstraint)
                         && $valid;

            } else if (!$fieldConstraint instanceof IsOptional) {
                $this->violationBuilder->addViolation(
                    null,
                    ErrorCodes::MISSING_FIELD_ERROR()->value(),
                    ['field' => $field],
                    $fieldConstraint
                );
                $valid = false;
            }
        }

        foreach ($value as $field => $fieldValue) {
            if (!isset($constraint->fields[$field])) {
                $this->violationBuilder
                    ->setPath($mainPath . '/' . $field)
                    ->addViolation(
                        $fieldValue,
                        ErrorCodes::NO_SUCH_FIELD_ERROR()->value(),
                        [],
                        $constraint
                    );
                $valid = false;
            }
        }
        $this->violationBuilder->setPath($mainPath);

        return $valid;

    }

}
