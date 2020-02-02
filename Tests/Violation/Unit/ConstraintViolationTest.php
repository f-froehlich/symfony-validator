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

namespace FabianFroehlich\Validator\Tests\Violation\Unit;

use FabianFroehlich\Core\Util\Test\UnitTestCase;
use FabianFroehlich\Validator\Constraints\AbstractConstraint;
use FabianFroehlich\Validator\Violation\ConstraintViolation;
use PHPUnit\Framework\MockObject\MockObject;

class ConstraintViolationTest
    extends UnitTestCase {
    /**
     * @var MockObject|AbstractConstraint
     */
    private $constraint;

    public function setUp(): void {
        parent::setUp();

        $this->constraint = $this->getMockBuilder(AbstractConstraint::class)
                                 ->disableOriginalConstructor()
                                 ->getMockForAbstractClass();
    }

    /**
     * @test
     */
    public function canCreateViolation(): void {
        $message      = 'msg';
        $path         = 'path';
        $invalidValue = 'invalidValue';
        $code         = 'code';
        $violation    = new ConstraintViolation($message, $path, $invalidValue, $code, $this->constraint);

        $this->assertEquals($message, $violation->getMessage());
        $this->assertEquals($path, $violation->getPropertyPath());
        $this->assertEquals($invalidValue, $violation->getInvalidValue());
        $this->assertEquals($code, $violation->getCode());
        $this->assertEquals($this->constraint, $violation->getConstraint());
    }
}