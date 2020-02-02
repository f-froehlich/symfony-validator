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
use ArrayIterator;
use FabianFroehlich\Validator\Exception\LogicException;
use IteratorAggregate;
use OutOfBoundsException;
use function count;

/**
 * Class ConstraintViolationList
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Violation
 */
class ConstraintViolationList
    implements IteratorAggregate, ArrayAccess {

    /** @var ConstraintViolation[] */
    private $violations = [];

    /**
     * Creates a new constraint violation list.
     *
     * @param ConstraintViolationList[] $violations The constraint violations to add to the list
     */
    public function __construct(array $violations = []) {

        foreach ($violations as $violation) {
            $this->add($violation);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function add(ConstraintViolation $violation): ConstraintViolationList {

        $this->violations[] = $violation;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addAll(array $otherList): ConstraintViolationList {

        foreach ($otherList as $violation) {
            $this->violations[] = $violation;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @return ArrayIterator|ConstraintViolationList[]
     */
    public function getIterator() {

        return new ArrayIterator($this->violations);
    }

    /**
     * @return int
     */
    public function count() {

        return count($this->violations);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetExists($offset) {
        if (!is_int($offset)) {
            throw new LogicException('Keys can only be int for this list');
        }

        return $this->has($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function has(int $offset): bool {

        return isset($this->violations[$offset]);
    }

    /**
     * {@inheritdoc}
     * @return ConstraintViolation
     */
    public function offsetGet($offset) {

        if (!is_int($offset)) {
            throw new LogicException('Keys can only be int for this list');
        }

        return $this->get($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function get(int $offset): ConstraintViolation {

        if (!isset($this->violations[$offset])) {
            throw new OutOfBoundsException(sprintf('The offset "%s" does not exist.', $offset));
        }

        return $this->violations[$offset];
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $violation) {

        if (!($violation instanceof ConstraintViolation)) {
            throw new LogicException('Can only add ' . ConstraintViolation::class . ' to this list');
        }

        if (!is_int($offset)) {
            throw new LogicException('Keys can only be int for this list');
        }

        $this->set($offset, $violation);
    }

    /**
     * {@inheritdoc}
     */
    public function set(int $offset, ConstraintViolation $violation): ConstraintViolationList {

        $this->violations[$offset] = $violation;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset) {

        $this->remove($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function remove($offset): ConstraintViolationList {

        unset($this->violations[$offset]);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getAll(): array {
        return $this->violations;
    }

}
