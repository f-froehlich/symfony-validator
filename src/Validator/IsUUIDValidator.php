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
use FabianFroehlich\Validator\Constraints\IsUUID;
use FabianFroehlich\Validator\Enums\ErrorCodes;

/**
 * Class IsUUIDValidator
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Validator
 */
class IsUUIDValidator
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

        return IsUUID::class;
    }

    /**
     * @param string $value
     * @param IsUUID $constraint
     *
     * @return bool
     */
    protected function customValidation($value, AbstractConstraint $constraint): bool {

        if (36 !== strlen($value)) {
            $this->violationBuilder->addViolation(
                $value,
                ErrorCodes::UUID_INVALID_LENGTH()->value(),
                ['currentLength' => strlen($value)],
                $constraint
            );

            return false;
        }

        if (!$this->validateHyphens($value, $constraint)) {
            return false;
        }

        $uuidGroups = explode('-', $value);
        if (5 !== count($uuidGroups)) {
            $this->violationBuilder->addViolation(
                $value,
                ErrorCodes::UUID_GROUP_COUNT_INVALID()->value(),
                ['current' => count($uuidGroups)],
                $constraint
            );
            return false;
        }


        $valid = $this->validateGroup($uuidGroups[0], 'first', $value, $constraint);
        $valid = $this->validateGroup($uuidGroups[1], 'second', $value, $constraint) && $valid;
        $valid = $this->validateGroup($uuidGroups[2], 'third', $value, $constraint) && $valid;
        $valid = $this->validateGroup($uuidGroups[3], 'forth', $value, $constraint) && $valid;
        $valid = $this->validateGroup($uuidGroups[4], 'fifth', $value, $constraint) && $valid;

        $valid = $this->validateVersion($uuidGroups[2], $value, $constraint) && $valid;
        $valid = $this->validateVariant($uuidGroups[3], $value, $constraint) && $valid;

        return $valid;
    }

    /**
     * @param string $value
     * @param IsUUID $constraint
     *
     * @return bool
     */
    private function validateHyphens(string $value, IsUUID $constraint): bool {
        $hyphenPositions = [8, 13, 18, 23];
        $valid           = true;
        foreach ($hyphenPositions as $hyphenPosition) {
            if ('-' !== $value[$hyphenPosition]) {
                $this->violationBuilder->addViolation(
                    $value,
                    ErrorCodes::UUID_INVALID_HYPHEN_POS()->value(),
                    ['current' => substr($hyphenPosition, $hyphenPosition, 1)],
                    $constraint
                );
                $valid = false;
            }
        }

        return $valid;
    }

    /**
     * @param string $group
     * @param string $key
     * @param string $value
     * @param IsUUID $constraint
     *
     * @return bool
     */
    private function validateGroup(string $group, string $key, string $value, IsUUID $constraint): bool {
        // groups must be xdigit
        if (!ctype_xdigit($group)) {
            $this->violationBuilder->addViolation(
                $value,
                ErrorCodes::UUID_INVALID_BLOCK()->value(),
                ['block' => $key],
                $constraint
            );

            return false;
        }

        return true;
    }

    /**
     * @param string $versionGroup
     * @param string $value
     * @param IsUUID $constraint
     *
     * @return bool
     */
    private function validateVersion(string $versionGroup, string $value, IsUUID $constraint): bool {
        $validVersions = ['1', '2', '3', '4'];
        $version       = $versionGroup[0];

        if (!in_array($version, $validVersions, true)) {
            $this->violationBuilder->addViolation(
                $value,
                ErrorCodes::UUID_INVALID_VERSION()->value(),
                ['unknownVersion' => $version],
                $constraint
            );

            return false;
        }

        return true;
    }

    /**
     * @param string $variantGroup
     * @param string $value
     * @param IsUUID $constraint
     *
     * @return bool
     */
    private function validateVariant(string $variantGroup, string $value, IsUUID $constraint): bool {
        $validVariants = ['1', '2', '3'];
        $variant       = $variantGroup[0];

        if (!in_array($variant, $validVariants, true)) {
            $this->violationBuilder->addViolation(
                $value,
                ErrorCodes::UUID_INVALID_VARIANT()->value(),
                ['unknownVariant' => $variant],
                $constraint
            );

            return false;
        }

        return true;
    }

}
