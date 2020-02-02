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
use FabianFroehlich\Validator\Constraints\All;

/**
 * Class AllValidator
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Validator
 */
class AllValidator
    extends AbstractConstraintValidator {

    public function getRequiredType(): string {

        return self::LIST;
    }

    public function getRequiredConstraint(): string {

        return All::class;
    }

    /**
     * @param mixed $value
     * @param All   $constraint
     *
     * @return bool
     */
    protected function customValidation($value, AbstractConstraint $constraint): bool {

        $mainPath = $this->violationBuilder->getPath();
        $valid    = true;
        foreach ($value as $key => $element) {
            $valid = $this->violationBuilder
                         ->setPath($mainPath . '/[' . $key . ']')
                         ->validateValue($element, $constraint->constraints)
                     && $valid;
        }
        $this->violationBuilder->setPath($mainPath);

        return $valid;

    }

}
