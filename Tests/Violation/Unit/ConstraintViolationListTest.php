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
use FabianFroehlich\Validator\Exception\LogicException;
use FabianFroehlich\Validator\Violation\ConstraintViolation;
use FabianFroehlich\Validator\Violation\ConstraintViolationList;
use OutOfBoundsException;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * Class ConstraintViolationListTest
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Tests\Violation\Unit
 */
class ConstraintViolationListTest
    extends UnitTestCase {
    /**
     * @var MockObject|AbstractConstraint
     */
    private $constraint;
    /**
     * @var ConstraintViolation
     */
    private $violation1;
    /**
     * @var ConstraintViolation
     */
    private $violation2;
    /**
     * @var ConstraintViolation
     */
    private $violation3;

    public function setUp(): void {
        parent::setUp();

        $this->constraint = $this->getMockBuilder(AbstractConstraint::class)
                                 ->disableOriginalConstructor()
                                 ->getMockForAbstractClass();
        $this->violation1 = new ConstraintViolation('msg1', 'path1', 'invalidValue1', 'code1', $this->constraint);
        $this->violation2 = new ConstraintViolation('msg2', 'path2', 'invalidValue2', 'code2', $this->constraint);
        $this->violation3 = new ConstraintViolation('msg3', 'path3', 'invalidValue3', 'code3', $this->constraint);
    }

    /**
     * @test
     */
    public function canCreateEmptyViolationList(): void {
        $list = new ConstraintViolationList();
        $this->assertCount(0, $list);
    }

    /**
     * @test
     */
    public function canCreateViolationListWithEntries(): void {
        $entries = [
            $this->violation1,
            $this->violation2,
            $this->violation3,
        ];

        $list = new ConstraintViolationList($entries);
        $this->assertCount(3, $list);

        foreach ($list->getAll() as $violation) {
            $this->assertContains($violation, $entries);
        }
    }


    /**
     * @test
     */
    public function canAddToList(): void {

        $list = new ConstraintViolationList();
        $list->add($this->violation1);
        $this->assertCount(1, $list);
        $this->assertSame($this->violation1, $list->get(0));
        $this->assertEquals(1, $list->count());
        $list->add($this->violation2);
        $this->assertCount(2, $list);
        $this->assertSame($this->violation1, $list->get(0));
        $this->assertSame($this->violation2, $list->get(1));
        $this->assertEquals(2, $list->count());

    }


    /**
     * @test
     */
    public function canAddAllToList(): void {
        $entries = [
            $this->violation1,
            $this->violation2,
            $this->violation3,
        ];

        $list = new ConstraintViolationList();
        $list->addAll($entries);
        $this->assertCount(3, $list);

        foreach ($list->getAll() as $violation) {
            $this->assertContains($violation, $entries);
        }
    }

    /**
     * @test
     */
    public function cantGetUndefinedOffset(): void {

        $this->expectException(OutOfBoundsException::class);
        $this->expectExceptionMessage('The offset "0" does not exist.');
        $list = new ConstraintViolationList();
        $list->get(0);
    }

    /**
     * @test
     */
    public function cantSetOffsetIfValueIsInvalid(): void {

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Can only add ' . ConstraintViolation::class . ' to this list');
        $list = new ConstraintViolationList();
        $list->offsetSet(0, null);
    }

    /**
     * @test
     */
    public function cantSetOffsetIfKeyIsInvalid(): void {

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Keys can only be int for this list');
        $list = new ConstraintViolationList();
        $list->offsetSet(null, $this->violation1);
    }

    /**
     * @test
     */
    public function offsetExistMustGetOffsetInt(): void {

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Keys can only be int for this list');
        $list = new ConstraintViolationList();
        $list->offsetExists(null);
    }

    /**
     * @test
     */
    public function offsetGetMustGetOffsetInt(): void {

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Keys can only be int for this list');
        $list = new ConstraintViolationList();
        $list->offsetGet(null);
    }


    /**
     * @test
     */
    public function canSetOffset(): void {

        $list = new ConstraintViolationList();
        $list->offsetSet(3, $this->violation1);
        $this->assertTrue($list->offsetExists(3));
        $this->assertSame($this->violation1, $list->offsetGet(3));

    }

    /**
     * @test
     */
    public function canRemoveOffset(): void {

        $list = new ConstraintViolationList();
        $list->offsetSet(3, $this->violation1);
        $this->assertSame($this->violation1, $list->get(3));
        $list->offsetUnset(3);
        $this->assertEquals(0, $list->count());

    }
}