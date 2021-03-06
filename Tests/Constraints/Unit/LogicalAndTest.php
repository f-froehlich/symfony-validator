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

namespace FabianFroehlich\Validator\Tests\Constraints\Unit;


use FabianFroehlich\Validator\Constraints\IsBool;
use FabianFroehlich\Validator\Constraints\LogicalAnd;
use FabianFroehlich\Validator\Tests\AbstractLogicalConstraintTestCase;
use FabianFroehlich\Validator\Validator\LogicalAndValidator;

/**
 * Class LogicalAndTest
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Tests\Constraints\Unit
 */
class LogicalAndTest
    extends AbstractLogicalConstraintTestCase {

    /**
     * {@inheritDoc}
     */
    public function getRequiredValidatorClass(): string {

        return LogicalAndValidator::class;
    }


    /**
     * {@inheritDoc}
     */
    protected function initConstraint(): void {

        $constraintClass  = $this->getConstraintClass();
        $this->constraint = new $constraintClass(['left' => new IsBool(), 'right' => new IsBool()]);
    }

    /**
     * {@inheritDoc}
     */
    public function getConstraintClass(): string {

        return LogicalAnd::class;
    }

    /**
     * @inheritDoc
     */
    protected function getTranslationDomain(): string {
        return 'LogicalAnd';
    }


}