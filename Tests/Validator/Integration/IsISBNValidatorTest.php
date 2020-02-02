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

namespace FabianFroehlich\Validator\Tests\Validator\Integration;


use FabianFroehlich\Validator\Constraints\IsISBN;
use FabianFroehlich\Validator\Tests\AbstractISBNValidatorTestCase;

/**
 * Class IsISBNValidatorTest
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Tests\Validator\Integration
 */
class IsISBNValidatorTest
    extends AbstractISBNValidatorTestCase {

    /**
     * @test
     */
    public function checkValidIsbn10(): void {
        parent::checkValidIsbn10();
    }

    /**
     * @test
     */
    public function checkInvalidIsbn10(): void {
        parent::checkInvalidIsbn10();
    }

    /**
     * @test
     */
    public function checkValidIsbn13(): void {
        parent::checkValidIsbn13();
    }

    /**
     * @test
     */
    public function checkInvalidIsbn13(): void {
        parent::checkInvalidIsbn13();
    }

    /**
     * {@inheritDoc}
     */
    protected function getConstraintClass(): string {

        return IsISBN::class;
    }

}