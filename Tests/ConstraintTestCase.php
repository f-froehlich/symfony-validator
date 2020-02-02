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

use FabianFroehlich\Core\Util\Test\UnitTestCase;
use FabianFroehlich\Validator\Constraints\AbstractConstraint;

/**
 * Class ConstraintTestCase
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Tests
 */
abstract class ConstraintTestCase
    extends UnitTestCase {


    /** @var AbstractConstraint */
    protected $constraint;

    public function setUp(): void {

        parent::setUp();

        $this->initConstraint();
    }

    /**
     * Initialise the constraint
     */
    protected function initConstraint(): void {

        $constraintClass  = $this->getConstraintClass();
        $this->constraint = new $constraintClass();
    }

    /**
     * get Constraint class
     *
     * @return string
     */
    abstract protected function getConstraintClass(): string;

    /**
     * @test
     */
    public function constraintHasRightValidator(): void {

        $this->assertEquals($this->getRequiredValidatorClass(), $this->constraint->validatedBy());
    }

    /**
     * get the required Validator Class
     *
     * @return string
     */
    abstract protected function getRequiredValidatorClass(): string;

    /**
     * @test
     */
    public function constraintHasRightTranslationDomain(): void {

        $this->assertEquals($this->getTranslationDomain(), $this->constraint->getTranslationDomain());
    }

    /**
     * Get the translation Domain for test
     *
     * @return string
     */
    abstract protected function getTranslationDomain(): string;

}