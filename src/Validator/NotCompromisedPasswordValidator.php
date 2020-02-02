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
use FabianFroehlich\Validator\Constraints\IsPassword;
use FabianFroehlich\Validator\Constraints\NotCompromisedPassword;
use FabianFroehlich\Validator\Enums\ErrorCodes;
use FabianFroehlich\Validator\Violation\ConstraintViolationBuilderInterface;

/**
 * Class NotCompromisedPasswordValidator
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Validator
 */
class NotCompromisedPasswordValidator
    extends AbstractConstraintValidator {

    private $passwordConstraint;

    public function __construct(ConstraintViolationBuilderInterface $violationBuilder) {
        parent::__construct($violationBuilder);
        $this->passwordConstraint = new IsPassword();
    }

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

        return NotCompromisedPassword::class;
    }

    /**
     * @param                        $value
     * @param NotCompromisedPassword $constraint
     *
     * @return bool
     */
    protected function customValidation($value, AbstractConstraint $constraint): bool {


        $valid = $this->violationBuilder->validateValue($value, $this->passwordConstraint);

        $hash       = strtoupper(sha1($value));
        $hashPrefix = substr($hash, 0, 5);
        $hashSuffix = str_replace($hashPrefix, '', $hash);


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.pwnedpasswords.com/range/' . $hashPrefix);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);


        if (false !== strpos($result, $hashSuffix)) {
            $this->violationBuilder->addViolation($value, ErrorCodes::PASSWORD_COMPROMISED()->value(), [], $constraint);

            return false;
        }

        return $valid;
    }

}
