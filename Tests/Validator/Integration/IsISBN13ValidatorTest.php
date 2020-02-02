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


use FabianFroehlich\Validator\Constraints\IsISBN13;
use FabianFroehlich\Validator\Tests\AbstractISBNValidatorTestCase;

/**
 * Class IsISBN13ValidatorTest
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Tests\Validator\Integration
 */
class IsISBN13ValidatorTest
    extends AbstractISBNValidatorTestCase {

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
     * @test
     */
    public function checkInvalidLength13(): void {
        $this->checkLength($this->getInvalidIsbn13Length());
    }

    /**
     * {@inheritDoc}
     */
    protected function getConstraintClass(): string {

        return IsISBN13::class;
    }

}