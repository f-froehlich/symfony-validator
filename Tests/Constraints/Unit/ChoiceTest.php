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


use FabianFroehlich\Validator\Constraints\Choice;
use FabianFroehlich\Validator\Exception\ConstraintDefinitionException;
use FabianFroehlich\Validator\Tests\ConstraintTestCase;
use FabianFroehlich\Validator\Validator\ChoiceValidator;

/**
 * Class ChoiceTest
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Tests\Constraints\Unit
 */
class ChoiceTest
    extends ConstraintTestCase {

    /**
     * @test
     */
    public function constructorWillThrowExceptionIfChoicesAreNotAnArray(): void {

        $this->expectExceptionMessage('Choices must be an array');
        $this->expectException(ConstraintDefinitionException::class);

        $constraintClass = $this->getConstraintClass();
        new $constraintClass('string');
    }

    /**
     * {@inheritDoc}
     */
    protected function getConstraintClass(): string {

        return Choice::class;
    }

    /**
     * {@inheritDoc}
     */
    protected function getRequiredValidatorClass(): string {

        return ChoiceValidator::class;
    }

    /**
     * @inheritDoc
     */
    protected function getTranslationDomain(): string {
        return 'Choice';
    }

}