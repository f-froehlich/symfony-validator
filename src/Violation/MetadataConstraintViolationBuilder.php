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

namespace FabianFroehlich\Validator\Violation;


use ArrayAccess;
use Doctrine\Common\Annotations\Reader;
use FabianFroehlich\Validator\Constraints\AbstractConstraint;
use FabianFroehlich\Validator\Exception\LogicException;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class MetadataConstraintViolationBuilder
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Violation
 */
class MetadataConstraintViolationBuilder
    extends DataConstraintViolationBuilder {

    /** @var Reader */
    private $reader;

    /**
     * MetadataConstraintViolationBuilder constructor.
     *
     * @param ContainerInterface  $container
     * @param Reader              $reader
     * @param TranslatorInterface $translator
     */
    public function __construct(ContainerInterface $container, Reader $reader, TranslatorInterface $translator) {

        parent::__construct($container, $translator);
        $this->reader = $reader;
    }

    /**
     * @param array|ArrayAccess $collection
     *
     * @throws ReflectionException
     */
    public function validateCollection($collection): void {

        if (!is_array($collection) && !($collection instanceof ArrayAccess)) {
            throw new LogicException('Can only validate array|ArrayAccess');
        }
        foreach ($collection as $class) {
            $this->validateClass($class);
        }
    }

    /**
     * Validating a class
     *
     * @param $class
     *
     * @return bool class valid
     * @throws ReflectionException
     */
    public function validateClass($class): bool {

        $reflectionClass = new ReflectionClass($class);
        $properties      = $reflectionClass->getProperties();

        $valid = true;
        foreach ($properties as $property) {

            $value       = $property->getValue($class);
            $annotations = $this->reader->getPropertyAnnotations($property);

            foreach ($annotations as $annotation) {
                if ($annotation instanceof AbstractConstraint) {
                    $valid = $this->validateValue($value, $annotation) && $valid;
                }
            }
        }

        return $valid;
    }

}