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


use FabianFroehlich\Validator\Constraints\AbstractConstraint;
use FabianFroehlich\Validator\Constraints\IsBool;
use FabianFroehlich\Validator\Constraints\IsOptional;
use FabianFroehlich\Validator\Exception\ConstraintDefinitionException;
use FabianFroehlich\Validator\Tests\ConstraintTestCase;
use FabianFroehlich\Validator\Validator\IsOptionalValidator;

/**
 * Class IsOptionalTest
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Tests\Constraints\Unit
 */
class IsOptionalTest
    extends ConstraintTestCase {

    /**
     * {@inheritDoc}
     */
    public function getRequiredValidatorClass(): string {

        return IsOptionalValidator::class;
    }

    /**
     * @test
     */
    public function constructorWillSucceed(): void {

        $constraint = new IsBool();
        new IsOptional($constraint);

        $this->assertEquals($this->constraint->constraint, $constraint);
    }

    /**
     * @test
     */
    public function constructorWillSucceedIfConstraintIsInArray(): void {

        $constraint = new IsBool();
        new IsOptional(['constraint' => $constraint]);

        $this->assertEquals($this->constraint->constraint, $constraint);
    }

    /**
     * @test
     */
    public function constructorWillThrowExceptionIfNoConstraintIsSetInArray(): void {

        $this->expectExceptionMessage('Key \'constraint\' must be set');
        $this->expectException(ConstraintDefinitionException::class);

        new IsOptional([]);
    }

    /**
     * @test
     */
    public function constructorWillThrowExceptionIfConstraintIsNotAbstractConstraintInArray(): void {

        $this->expectExceptionMessage('Constraint must be type of ' . AbstractConstraint::class);
        $this->expectException(ConstraintDefinitionException::class);

        new IsOptional(['constraint' => true]);
    }

    /**
     * @test
     */
    public function constructorWillThrowExceptionIfConstraintIsNotAbstractConstraint(): void {

        $this->expectExceptionMessage('Constraint must be type of ' . AbstractConstraint::class);
        $this->expectException(ConstraintDefinitionException::class);

        new IsOptional(true);
    }

    /**
     * {@inheritDoc}
     */
    protected function initConstraint(): void {

        $constraintClass  = $this->getConstraintClass();
        $this->constraint = new $constraintClass(new IsBool());
    }

    /**
     * {@inheritDoc}
     */
    public function getConstraintClass(): string {

        return IsOptional::class;
    }

    /**
     * @inheritDoc
     */
    protected function getTranslationDomain(): string {
        return 'IsOptional';
    }


}