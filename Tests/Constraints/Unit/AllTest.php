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


use FabianFroehlich\Validator\Constraints\All;
use FabianFroehlich\Validator\Constraints\Collection;
use FabianFroehlich\Validator\Exception\ConstraintDefinitionException;
use FabianFroehlich\Validator\Tests\ConstraintTestCase;
use FabianFroehlich\Validator\Validator\AllValidator;

/**
 * Class AllTest
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Tests\Constraints\Unit
 */
class AllTest
    extends ConstraintTestCase {

    /**
     * {@inheritDoc}
     */
    public function getRequiredValidatorClass(): string {

        return AllValidator::class;
    }


    /**
     * @test
     */
    public function constructorWillSucceed(): void {

        $constraint       = new Collection([]);
        $this->constraint = new All($constraint);

        $this->assertEquals($this->constraint->constraints, $constraint);
    }

    /**
     * @test
     */
    public function constructorWillThrowExceptionIfCollectionKeyNotINArray(): void {
        $this->expectException(ConstraintDefinitionException::class);
        $this->expectExceptionMessage('Key \'collection\' must be set');
        new All([]);
    }

    /**
     * @test
     */
    public function constructorWillThrowExceptionIfCollectionKeyNotCollection(): void {
        $this->expectException(ConstraintDefinitionException::class);
        $this->expectExceptionMessage(All::class . ' can only have ' . Collection::class . ' as Constraint');
        new All(['collection' => true]);
    }

    /**
     * @test
     */
    public function constructorWillThrowExceptionIfNoCollectionGiven(): void {
        $this->expectException(ConstraintDefinitionException::class);
        $this->expectExceptionMessage(All::class . ' can only have ' . Collection::class . ' as Constraint');
        new All(true);
    }

    /**
     * {@inheritDoc}
     */
    protected function initConstraint(): void {

        $constraintClass  = $this->getConstraintClass();
        $this->constraint = new $constraintClass(new Collection());
    }

    /**
     * {@inheritDoc}
     */
    public function getConstraintClass(): string {

        return All::class;
    }

    /**
     * @inheritDoc
     */
    protected function getTranslationDomain(): string {
        return 'All';
    }
}