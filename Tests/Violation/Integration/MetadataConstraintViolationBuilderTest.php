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


namespace FabianFroehlich\Validator\Tests\Violation\Integration;


use Doctrine\Common\Collections\ArrayCollection;
use FabianFroehlich\Validator\Exception\LogicException;
use FabianFroehlich\Validator\Tests\BundleTestCase;
use FabianFroehlich\Validator\Tests\Violation\Fixtures\Entity;
use FabianFroehlich\Validator\Violation\MetadataConstraintViolationBuilder;
use ReflectionException;
use stdClass;

/**
 * Class MetadataConstraintViolationBuilderTest
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Tests\Violation\Integration
 */
class MetadataConstraintViolationBuilderTest
    extends BundleTestCase {

    /**
     * @var MetadataConstraintViolationBuilder
     */
    private $metadataConstraintBuilder;

    public function setUp(): void {
        parent::setUp();

        $this->metadataConstraintBuilder = $this->containerStore->get(MetadataConstraintViolationBuilder::class);
    }

    public function tearDown(): void {
        parent::tearDown();
        $this->metadataConstraintBuilder->reset();
    }

    /**
     * @test
     */
    public function validateClassSuccessful(): void {
        $entity = new Entity();
        $this->metadataConstraintBuilder->validateClass($entity);
        $violations = $this->metadataConstraintBuilder->getViolations();
        $this->assertCount(2, $violations);
        $this->assertEquals('NOT_GREATER_ERROR', $violations[0]->getMessage());
        $this->assertEquals(0, $violations[0]->getInvalidValue());

        $this->assertEquals('NOT_FALSE_ERROR', $violations[1]->getMessage());
        $this->assertEquals('/[0]/false', $violations[1]->getPropertyPath());
        $this->assertTrue($violations[1]->getInvalidValue());
    }

    /**
     * @test
     */
    public function validateCollectionArraySuccessful(): void {
        $entity = new Entity();
        $this->metadataConstraintBuilder->validateCollection([$entity, $entity]);
        $violations = $this->metadataConstraintBuilder->getViolations();
        $this->assertCount(4, $violations);

        $this->assertEquals('NOT_GREATER_ERROR', $violations[0]->getMessage());
        $this->assertEquals(0, $violations[0]->getInvalidValue());

        $this->assertEquals('NOT_FALSE_ERROR', $violations[1]->getMessage());
        $this->assertEquals('/[0]/false', $violations[1]->getPropertyPath());
        $this->assertTrue($violations[1]->getInvalidValue());

        $this->assertEquals('NOT_GREATER_ERROR', $violations[2]->getMessage());
        $this->assertEquals(0, $violations[2]->getInvalidValue());

        $this->assertEquals('NOT_FALSE_ERROR', $violations[3]->getMessage());
        $this->assertEquals('/[0]/false', $violations[3]->getPropertyPath());
        $this->assertTrue($violations[3]->getInvalidValue());
    }

    /**
     * @test
     */
    public function validateCollectionArrayAccessSuccessful(): void {
        $entity = new Entity();
        $this->metadataConstraintBuilder->validateCollection(new ArrayCollection([$entity, $entity]));
        $violations = $this->metadataConstraintBuilder->getViolations();
        $this->assertCount(4, $violations);

        $this->assertEquals('NOT_GREATER_ERROR', $violations[0]->getMessage());
        $this->assertEquals(0, $violations[0]->getInvalidValue());

        $this->assertEquals('NOT_FALSE_ERROR', $violations[1]->getMessage());
        $this->assertEquals('/[0]/false', $violations[1]->getPropertyPath());
        $this->assertTrue($violations[1]->getInvalidValue());

        $this->assertEquals('NOT_GREATER_ERROR', $violations[2]->getMessage());
        $this->assertEquals(0, $violations[2]->getInvalidValue());

        $this->assertEquals('NOT_FALSE_ERROR', $violations[3]->getMessage());
        $this->assertEquals('/[0]/false', $violations[3]->getPropertyPath());
        $this->assertTrue($violations[3]->getInvalidValue());
    }

    /**
     * @test
     */
    public function validateCollectionWillThrowExceptionIfNoArrayOrArrayAccessGiven(): void {

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Can only validate array|ArrayAccess');
        $this->metadataConstraintBuilder->validateCollection(false);
    }

    /**
     * @throws ReflectionException
     * @test
     */
    public function cantPassInteger(): void {
        $this->expectException(ReflectionException::class);

        $this->metadataConstraintBuilder->validateClass(5);
    }

    /**
     * @throws ReflectionException
     * @test
     */
    public function cantPassFloat(): void {
        $this->expectException(ReflectionException::class);

        $this->metadataConstraintBuilder->validateClass(5.0);
    }

    /**
     * @throws ReflectionException
     * @test
     */
    public function cantPassBooleanTrue(): void {
        $this->expectException(ReflectionException::class);

        $this->metadataConstraintBuilder->validateClass(true);
    }

    /**
     * @throws ReflectionException
     * @test
     */
    public function cantPassBooleanFalse(): void {
        $this->expectException(ReflectionException::class);

        $this->metadataConstraintBuilder->validateClass(false);
    }

    /**
     * @throws ReflectionException
     * @test
     */
    public function cantPassNull(): void {
        $this->expectException(ReflectionException::class);

        $this->metadataConstraintBuilder->validateClass(null);
    }

    /**
     * @throws ReflectionException
     * @test
     */
    public function cantPassArray(): void {
        $this->expectError();
        $this->expectErrorMessage('Array to string conversion');

        $this->metadataConstraintBuilder->validateClass([]);
    }

    /**
     * @throws ReflectionException
     * @test
     */
    public function cantPassString(): void {
        $this->expectException(ReflectionException::class);

        $this->metadataConstraintBuilder->validateClass('string');
    }

    /**
     * @throws ReflectionException
     * @test
     */
    public function cantPassResource(): void {
        $this->expectException(ReflectionException::class);

        $this->metadataConstraintBuilder->validateClass(tmpfile());
    }

    /**
     * @throws ReflectionException
     * @test
     */
    public function canPassObject(): void {

        $this->metadataConstraintBuilder->validateClass(new stdClass());
        $this->assertCount(0, $this->metadataConstraintBuilder->getViolations());
    }

    /**
     * @throws ReflectionException
     * @test
     */
    public function canPassCallable(): void {

        $this->metadataConstraintBuilder->validateClass(
            static function () {
            }
        );
        $this->assertCount(0, $this->metadataConstraintBuilder->getViolations());
    }
}