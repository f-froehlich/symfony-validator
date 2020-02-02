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


use FabianFroehlich\Validator\Constraints\IsBetween;
use FabianFroehlich\Validator\Constraints\IsOptional;
use FabianFroehlich\Validator\Exception\ConstraintDefinitionException;
use FabianFroehlich\Validator\Tests\ConstraintTestCase;
use FabianFroehlich\Validator\Validator\IsBetweenValidator;

/**
 * Class IsBetweenTest
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Tests\Constraints\Unit
 */
class IsBetweenTest
    extends ConstraintTestCase {

    /**
     * {@inheritDoc}
     */
    public function getRequiredValidatorClass(): string {

        return IsBetweenValidator::class;
    }

    /**
     * @test
     */
    public function constructorWillThrowExceptionIfOptionsNotArray(): void {

        $this->expectExceptionMessage('Options must be array');
        $this->expectException(ConstraintDefinitionException::class);

        new IsBetween(true);
    }

    /**
     * @test
     */
    public function constructorWillThrowExceptionIfLowerBoundNotExistInArray(): void {

        $this->expectExceptionMessage('Key \'lower\' must be set');
        $this->expectException(ConstraintDefinitionException::class);

        new IsBetween([]);
    }

    /**
     * @test
     */
    public function constructorWillThrowExceptionIfUpperBoundNotExistInArray(): void {

        $this->expectExceptionMessage('Key \'upper\' must be set');
        $this->expectException(ConstraintDefinitionException::class);

        new IsBetween(['lower' => 0]);
    }

    /**
     * @test
     */
    public function constructorWillThrowExceptionIfIncludeUpperBoundIsNotBool(): void {

        $this->expectExceptionMessage('Key \'includeUpperBound\' must be bool');
        $this->expectException(ConstraintDefinitionException::class);

        new IsBetween(['lower' => 0, 'upper' => 0, 'includeUpperBound' => 0]);
    }

    /**
     * @test
     */
    public function constructorWillThrowExceptionIfIncludeLowerBoundIsNotBool(): void {

        $this->expectExceptionMessage('Key \'includeLowerBound\' must be bool');
        $this->expectException(ConstraintDefinitionException::class);

        new IsBetween(['lower' => 0, 'upper' => 0, 'includeLowerBound' => 0]);
    }

    /**
     * @test
     */
    public function constructorWillThrowExceptionIfLowerBoundIsNotIntOrFloat(): void {

        $this->expectExceptionMessage('Lower Bound must be an integer|float');
        $this->expectException(ConstraintDefinitionException::class);

        new IsBetween(['lower' => true]);
    }

    /**
     * @test
     */
    public function constructorWillThrowExceptionIfUpperBoundIsNotIntOrFloat(): void {

        $this->expectExceptionMessage('Upper Bound must be an integer|float');
        $this->expectException(ConstraintDefinitionException::class);

        new IsBetween(['lower' => -1, 'upper' => true]);
    }

    /**
     * @test
     */
    public function constructorWillThrowExceptionIfUpperBoundIsNotGreaterOrEqualThanLowerBound(): void {

        $this->expectExceptionMessage('Lower Bound must be lower or equal Upper Bound');
        $this->expectException(ConstraintDefinitionException::class);

        new IsBetween(['lower' => 1, 'upper' => -1]);
    }

    /**
     * @test
     */
    public function includeLowerBoundDefaultValueIsFalse(): void {


        $constraint = new IsBetween(['lower' => 0, 'upper' => 0]);
        $this->assertFalse($constraint->includeLowerBound);
    }

    /**
     * @test
     */
    public function includeUpperBoundDefaultValueIsFalse(): void {


        $constraint = new IsBetween(['lower' => 0, 'upper' => 0]);
        $this->assertFalse($constraint->includeUpperBound);
    }

    /**
     * {@inheritDoc}
     */
    public function getConstraintClass(): string {

        return IsOptional::class;
    }

    /**
     * {@inheritDoc}
     */
    protected function initConstraint(): void {

        $this->constraint = new IsBetween(['lower' => -1, 'upper' => 1]);
    }

    /**
     * @inheritDoc
     */
    protected function getTranslationDomain(): string {
        return 'IsBetween';
    }

}