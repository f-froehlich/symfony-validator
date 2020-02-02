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

use FabianFroehlich\Validator\Exception\ConstraintDefinitionException;

/**
 * Class AbstractBoundConstraintTestCase
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Tests
 */
abstract class AbstractBoundConstraintTestCase
    extends ConstraintTestCase {


    /**
     * @test
     */
    public function constructorWillSucceedIfIntIsGiven(): void {

        $constraintClass  = $this->getConstraintClass();
        $this->constraint = new $constraintClass(0);
        $this->assertEquals(0, $this->constraint->bound);
    }

    /**
     * @test
     */
    public function constructorWillSucceedIfFloatIsGiven(): void {

        $constraintClass  = $this->getConstraintClass();
        $this->constraint = new $constraintClass(0.0);
        $this->assertEquals(0.0, $this->constraint->bound);
    }

    /**
     * @test
     */
    public function constructorWillSucceedIfArrayWithIntIsGiven(): void {

        $constraintClass  = $this->getConstraintClass();
        $this->constraint = new $constraintClass(['bound' => 0]);
        $this->assertEquals(0, $this->constraint->bound);
    }

    /**
     * @test
     */
    public function constructorWillSucceedIfArrayWithFloatIsGiven(): void {

        $constraintClass  = $this->getConstraintClass();
        $this->constraint = new $constraintClass(['bound' => 0.0]);
        $this->assertEquals(0.0, $this->constraint->bound);
    }

    /**
     * @test
     */
    public function constructorCantSucceedIfNoBoundInArrayGiven(): void {

        $this->expectExceptionMessage('Key \'bound\' must be set');
        $this->expectException(ConstraintDefinitionException::class);

        $constraintClass  = $this->getConstraintClass();
        $this->constraint = new $constraintClass([]);
    }

    /**
     * @test
     */
    public function constructorWillThrowExceptionIfGivenOptionsConstraintIsInvalid(): void {

        $this->expectExceptionMessage('Bound must be an integer|float');
        $this->expectException(ConstraintDefinitionException::class);

        $constraintClass = $this->getConstraintClass();
        new $constraintClass('string');
    }

    /**
     * {@inheritDoc}
     */
    protected function initConstraint(): void {

        $constraintClass  = $this->getConstraintClass();
        $this->constraint = new $constraintClass(0);
    }
}