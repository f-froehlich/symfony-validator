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

namespace FabianFroehlich\Validator\Tests;


use FabianFroehlich\Validator\Constraints\AbstractConstraint;
use FabianFroehlich\Validator\Enums\ErrorCodes;
use FabianFroehlich\Validator\Exception\UnexpectedTypeException;
use FabianFroehlich\Validator\Validator\AbstractConstraintValidator;
use FabianFroehlich\Validator\Validator\CollectionValidator;
use FabianFroehlich\Validator\Violation\ConstraintViolation;
use FabianFroehlich\Validator\Violation\DataConstraintViolationBuilder;
use PHPUnit\Framework\MockObject\MockObject;
use stdClass;

/**
 * Class ValidatorTestCase
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Tests
 */
abstract class ValidatorTestCase
    extends BundleTestCase {
    protected const STRING                  = 'STRING';
    protected const INT                     = 'INT';
    protected const INT_ZERO                = 'INT_ZERO';
    protected const INT_POSITIVE            = 'INT_POSITIVE';
    protected const INT_NEGATIVE            = 'INT_NEGATIVE';
    protected const FLOAT                   = 'FLOAT';
    protected const FLOAT_ZERO              = 'FLOAT_ZERO';
    protected const FLOAT_POSITIVE          = 'FLOAT_POSITIVE';
    protected const FLOAT_NEGATIVE          = 'FLOAT_NEGATIVE';
    protected const BOOLEAN                 = 'BOOLEAN';
    protected const BOOLEAN_TRUE            = 'BOOLEAN_TRUE';
    protected const BOOLEAN_FALSE           = 'BOOLEAN_FALSE';
    protected const NULL                    = 'NULL';
    protected const ARRAY                   = 'ARRAY';
    protected const STD_CLASS               = 'OBJECT';
    protected const RESOURCE                = 'RESOURCE';
    protected const NUMBER_OR_STRING_INT    = 'NUMBER_OR_STRING_INT';
    protected const NUMBER_OR_STRING_FLOAT  = 'NUMBER_OR_STRING_FLOAT';
    protected const NUMBER_OR_STRING_STRING = 'NUMBER_OR_STRING_STRING';

    /** @var DataConstraintViolationBuilder */
    protected $validatorBuilder;

    /** @var AbstractConstraintValidator */
    protected $validator;

    /** @var bool|resource */
    private $tempFile;

    /**
     * @var MockObject|AbstractConstraint
     */
    private $constraintMock;

    /**
     * {@inheritDoc}
     */
    public function __construct($name = null, array $data = [], $dataName = '') {

        parent::__construct($name, $data, $dataName);

        $this->tempFile       = tmpfile();
        $this->constraintMock = $this->getMockBuilder(AbstractConstraint::class)
                                     ->disableOriginalConstructor()
                                     ->getMockForAbstractClass();

    }

    public function __destruct() {

        fclose($this->tempFile);
    }

    /**
     * {@inheritDoc}
     */
    public function setUp(): void {

        parent::setUp();

        $this->validatorBuilder = $this->validatorBuilder
                                  ?? $this->containerStore->get(DataConstraintViolationBuilder::class);
        $this->validator        = $this->validator
                                  ?? $this->containerStore->get($this->getConstraint()->validatedBy());
    }

    /**
     * Get the constraint for this validator
     *
     * @return AbstractConstraint
     */
    protected function getConstraint(): AbstractConstraint {

        $class = $this->getConstraintClass();

        return new $class();
    }

    /**
     * Get the constraint class for this validator
     *
     * @return string
     */
    abstract protected function getConstraintClass(): string;

    /**
     * {@inheritDoc}
     */
    public function tearDown(): void {

        parent::tearDown();

        $this->validatorBuilder->reset();
    }

    /**
     * @test
     */
    public function getRequiredConstraintWillGetRightConstraint(): void {

        $this->assertEquals($this->getConstraintClass(), $this->validator->getRequiredConstraint());
    }

    /**
     * @test
     */
    public function getRequiredTypeWillReturnRightType(): void {
        $this->assertEquals($this->getRequiredType(), $this->validator->getRequiredType());
    }

    /**
     * @return string
     */
    abstract protected function getRequiredType(): string;

    /**
     * @test
     */
    public function unexpectedConstraintWillThrowException(): void {

        $mockClassName = get_class($this->constraintMock);
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage(
            'Expected argument of type "' . $this->getConstraintClass() . '", "' . $mockClassName . '" given'
        );

        $this->validator->validate(false, $this->constraintMock);
    }

    /**
     * @test
     */
    public function allInvalidTypesWillAddAnConstraintViolation(): void {

        $typesToCheck = $this->getInvalidTypes($this->getValidTypes());

        foreach ($typesToCheck as $type => $value) {
            $this->assertFalse($this->validator->validate($value, $this->getConstraint()));
        }

        $violations = $this->validatorBuilder->getViolations();
        $this->assertCount(count($typesToCheck), $violations, 'Not all Violations where added.');

        $typeMap = [];
        foreach ($typesToCheck as $type => $value) {
            /** @var ConstraintViolation $violation */
            foreach ($violations as $violation) {
                if ($violation->getInvalidValue() === $value) {
                    $typeMap[$type] = $violation;
                    break;
                }
            }
        }

        $checkedTypes = [];
        /** @var ConstraintViolation $violation */
        foreach ($typeMap as $type => $violation) {
            $this->assertContains(
                $violation->getInvalidValue(),
                $typesToCheck,
                'Violation was added but it is from right type.'
            );
            $this->assertArrayNotHasKey($type, $checkedTypes, 'Violation was added twice.');
            $this->assertEmpty($violation->getPropertyPath(), 'Path must be empty because it is an root Element');

            // Ignoring message and code if Constraint pass all Types
            if (AbstractConstraintValidator::ALL !== $this->validator->getRequiredType()) {

                $this->assertEquals(
                    ErrorCodes::INVALID_VALUE_TYPE()->value(),
                    $violation->getCode(),
                    'Violation Code must be ' . ErrorCodes::INVALID_VALUE_TYPE()->value()
                );

                if (CollectionValidator::LIST === $this->validator->getRequiredType()) {
                    $this->assertEquals(
                        ErrorCodes::INVALID_VALUE_TYPE()->value(),
                        $violation->getCode()
                    );

                } else if (CollectionValidator::OPTIONAL === $this->validator->getRequiredType()) {

                    $this->assertEquals(
                        ErrorCodes::INVALID_VALUE_TYPE()->value(),
                        $violation->getMessage()
                    );

                } else if (CollectionValidator::NUMBER === $this->validator->getRequiredType()) {

                    $this->assertEquals(
                        ErrorCodes::INVALID_VALUE_TYPE()->value(),
                        $violation->getMessage()
                    );

                } else if (CollectionValidator::NUMBER_OR_STRING === $this->validator->getRequiredType()) {

                    $this->assertEquals(
                        ErrorCodes::INVALID_VALUE_TYPE()->value(),
                        $violation->getMessage()
                    );

                } else {
                    $this->assertEquals(
                        ErrorCodes::INVALID_VALUE_TYPE()->value(),
                        $violation->getMessage()
                    );
                }
            }

            $checkedTypes[$type] = $typesToCheck;
        }
    }

    /**
     * Get all invalid Types
     *
     * @param array $validTypes
     *
     * @return array
     */
    protected function getInvalidTypes(array $validTypes): array {

        $allTypes = $this->getAllTypesWithValues();

        foreach ($validTypes as $validType) {
            if (!array_key_exists($validType, $allTypes)) {
                $this->fail('Type ' . $validType . ' does not exist in all valid types!');

            } else {
                unset($allTypes[$validType]);
            }
        }

        return $allTypes;
    }

    /**
     * Get all types with values
     *
     * @return array
     */
    protected function getAllTypesWithValues(): array {

        return [
            self::STRING                  => 'string',
            self::INT                     => 4,
            self::INT_NEGATIVE            => -1,
            self::INT_ZERO                => 0,
            self::INT_POSITIVE            => 1,
            self::FLOAT                   => 1.0,
            self::FLOAT_NEGATIVE          => -1.0,
            self::FLOAT_ZERO              => 0.0,
            self::FLOAT_POSITIVE          => 1.0,
            self::BOOLEAN                 => true,
            self::BOOLEAN_TRUE            => true,
            self::BOOLEAN_FALSE           => false,
            self::NULL                    => null,
            self::ARRAY                   => [],
            self::STD_CLASS               => new stdClass(),
            self::RESOURCE                => $this->tempFile,
            self::NUMBER_OR_STRING_INT    => 0,
            self::NUMBER_OR_STRING_FLOAT  => 0.0,
            self::NUMBER_OR_STRING_STRING => 'string',
        ];
    }

    /**
     * Get the types that are valid for the Validator
     *
     * @return array
     */
    abstract protected function getValidTypes(): array;

    /**
     * @test
     */
    public function checkAllValidTypesArePassed(): void {

        $validTypes = $this->getValidTypes();


        $allTypes     = $this->getAllTypesWithValues();
        $invalidTypes = $this->getInvalidTypes($validTypes);

        foreach ($invalidTypes as $invalidType => $value) {
            if (!array_key_exists($invalidType, $allTypes)) {
                $this->fail('Type ' . $invalidType . ' does not exist in all types!');

            } else {
                unset($allTypes[$invalidType]);
            }
        }

        foreach ($allTypes as $type) {
            $this->validator->validate($type, $this->getConstraint());
        }

        $violations = $this->validatorBuilder->getViolations();
        /** @var ConstraintViolation $violation */
        foreach ($violations as $violation) {
            if (ErrorCodes::INVALID_VALUE_TYPE()->value() === $violation->getCode()) {
                $this->fail(
                    'Invalid Value Constraint where added but only valid constraints where checked. '
                    . $violation->__toString()
                );
            } else {
                $this->addToAssertionCount(1);
            }
        }

        if (0 === count($violations)) {
            // No Violations added so mark test complete
            $this->addToAssertionCount(1);
        }
    }

    /**
     * Get all types
     *
     * @return array
     */
    protected function getAllTypes(): array {

        return [
            self::STRING,
            self::INT,
            self::INT_NEGATIVE,
            self::INT_ZERO,
            self::INT_POSITIVE,
            self::FLOAT,
            self::FLOAT_NEGATIVE,
            self::FLOAT_ZERO,
            self::FLOAT_POSITIVE,
            self::BOOLEAN,
            self::BOOLEAN_TRUE,
            self::BOOLEAN_FALSE,
            self::NULL,
            self::ARRAY,
            self::STD_CLASS,
            self::RESOURCE,
            self::NUMBER_OR_STRING_STRING,
            self::NUMBER_OR_STRING_INT,
            self::NUMBER_OR_STRING_FLOAT,

        ];
    }

}