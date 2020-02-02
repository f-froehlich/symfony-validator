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


use FabianFroehlich\Validator\Constraints\Expression;
use FabianFroehlich\Validator\Exception\ConstraintDefinitionException;
use FabianFroehlich\Validator\Tests\ConstraintTestCase;
use FabianFroehlich\Validator\Validator\ExpressionValidator;

/**
 * Class ExpressionTest
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Tests\Constraints\Unit
 */
class ExpressionTest
    extends ConstraintTestCase {

    /**
     * @test
     */
    public function expressionSetCorrectly(): void {
        $this->assertEquals('exp', $this->constraint->expression);
    }

    /**
     * @test
     */
    public function constructorWillSucceed(): void {

        $constraint = new Expression(['expression' => 'exp']);
        $this->assertEquals('exp', $constraint->expression);
    }

    /**
     * @test
     */
    public function constructorWillThrowExceptionIfExpressionNotSet(): void {

        $this->expectExceptionMessage('Key \'expression\' must be set');
        $this->expectException(ConstraintDefinitionException::class);

        new Expression([]);
    }

    /**
     * @test
     */
    public function constructorWillThrowExceptionIfExpressionNotString(): void {

        $this->expectExceptionMessage('Expression must be string');
        $this->expectException(ConstraintDefinitionException::class);

        new Expression(true);
    }

    /**
     * {@inheritDoc}
     */
    protected function getRequiredValidatorClass(): string {

        return ExpressionValidator::class;
    }

    /**
     * {@inheritDoc}
     */
    protected function initConstraint(): void {
        $this->constraint = new Expression('exp');
    }

    /**
     * {@inheritDoc}
     */
    protected function getConstraintClass(): string {

        return Expression::class;
    }

    /**
     * @inheritDoc
     */
    protected function getTranslationDomain(): string {
        return 'Expression';
    }

}