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

namespace FabianFroehlich\Validator\Tests;

use FabianFroehlich\Validator\Constraints\AbstractConstraint;
use FabianFroehlich\Validator\Constraints\IsBool;
use FabianFroehlich\Validator\Exception\ConstraintDefinitionException;

/**
 * Class AbstractLogicalConstraintTestCase
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Tests
 */
abstract class AbstractLogicalConstraintTestCase
    extends ConstraintTestCase {


    /**
     * @test
     */
    public function constructorCantSucceedIfNoLeftInArrayGiven(): void {

        $this->expectExceptionMessage('Key \'left\' must be set');
        $this->expectException(ConstraintDefinitionException::class);

        $constraintClass  = $this->getConstraintClass();
        $this->constraint = new $constraintClass([]);
    }


    /**
     * @test
     */
    public function constructorCantSucceedIfLeftIsNotConstraint(): void {

        $this->expectExceptionMessage('Key \'left\' must be instance of ' . AbstractConstraint::class);
        $this->expectException(ConstraintDefinitionException::class);

        $constraintClass  = $this->getConstraintClass();
        $this->constraint = new $constraintClass(['left' => true]);
    }

    /**
     * @test
     */
    public function constructorCantSucceedIfNoRightInArrayGiven(): void {

        $this->expectExceptionMessage('Key \'right\' must be set');
        $this->expectException(ConstraintDefinitionException::class);

        $constraintClass  = $this->getConstraintClass();
        $this->constraint = new $constraintClass(['left' => new IsBool()]);
    }


    /**
     * @test
     */
    public function constructorCantSucceedIfRightIsNotConstraint(): void {

        $this->expectExceptionMessage('Key \'right\' must be instance of ' . AbstractConstraint::class);
        $this->expectException(ConstraintDefinitionException::class);

        $constraintClass  = $this->getConstraintClass();
        $this->constraint = new $constraintClass(['left' => new IsBool(), 'right' => true]);
    }

    /**
     * @test
     */
    public function constructorWillSucceed(): void {


        $left             = new IsBool();
        $right            = new IsBool();
        $constraintClass  = $this->getConstraintClass();
        $this->constraint = new $constraintClass(['left' => $left, 'right' => $right]);

        $this->assertEquals($left, $this->constraint->getLeft());
        $this->assertEquals($right, $this->constraint->getRight());
    }

}