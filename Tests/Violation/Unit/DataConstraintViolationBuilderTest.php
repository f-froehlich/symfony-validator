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
use FabianFroehlich\Validator\Violation\DataConstraintViolationBuilder;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class DataConstraintViolationBuilderTest
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Tests\Violation\Unit
 */
class DataConstraintViolationBuilderTest
    extends UnitTestCase {
    /**
     * @var MockObject|AbstractConstraint
     */
    private $constraint;
    /**
     * @var MockObject|ContainerInterface
     */
    private $container;
    /**
     * @var DataConstraintViolationBuilder
     */
    private $builder;

    /**
     * @var MockObject|TranslatorInterface
     */
    private $translator;

    public function setUp(): void {
        parent::setUp();

        $this->constraint = $this->getMockBuilder(AbstractConstraint::class)
                                 ->disableOriginalConstructor()
                                 ->getMockForAbstractClass();
        $this->constraint->method('getTranslationDomain')
                         ->willReturn('TranslationDomain');

        $this->container = $this->getMockBuilder(ContainerInterface::class)
                                ->disableOriginalConstructor()
                                ->getMock();

        $this->translator = $this->getMockBuilder(TranslatorInterface::class)
                                 ->disableOriginalConstructor()
                                 ->getMockForAbstractClass();

        $this->builder = new DataConstraintViolationBuilder($this->container, $this->translator);
    }

    /**
     * @test
     */
    public function canSetPath(): void {
        $this->builder->setPath('path');
        $this->assertEquals('path', $this->builder->getPath());
    }

    /**
     * @test
     */
    public function canAddViolation(): void {

        $this->translator->expects($this->once())
                         ->method('trans')
                         ->with('code', [], 'TranslationDomain', null)
                         ->willReturn('translatedCode');

        $this->builder->addViolation('invalidValue', 'code', [], $this->constraint);

        $list = $this->builder->getViolationList();
        $this->assertCount(1, $list);
        $violation = $list->get(0);
        $this->assertEquals('invalidValue', $violation->getInvalidValue());
        $this->assertEquals('code', $violation->getCode());
        $this->assertEquals('translatedCode', $violation->getMessage());
        $this->assertEquals($this->constraint, $violation->getConstraint());
    }


    /**
     * @test
     */
    public function willGetViolationListCorrectly(): void {
        $this->translator->expects($this->once())
                         ->method('trans')
                         ->with('code', [], 'TranslationDomain', null)
                         ->willReturn('translatedCode');

        $this->builder->addViolation('invalidValue', 'code', [], $this->constraint);

        $this->assertEquals($this->builder->getViolations(), $this->builder->getViolationList()->getAll());
    }


    /**
     * @test
     */
    public function resetWillCreateNewListAndResetPath(): void {

        $this->translator->expects($this->once())
                         ->method('trans')
                         ->with('code', [], 'TranslationDomain', null)
                         ->willReturn('translatedCode');

        $list = $this->builder->getViolationList();
        $this->builder->addViolation('invalidValue', 'code', [], $this->constraint);
        $this->builder->setPath('path');
        $this->builder->reset();
        $this->assertNotEquals($list, $this->builder->getViolationList());
        $this->assertEquals('', $this->builder->getPath());
    }

}