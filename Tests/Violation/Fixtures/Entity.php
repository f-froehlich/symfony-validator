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

namespace FabianFroehlich\Validator\Tests\Violation\Fixtures;

use Doctrine\Common\Collections\ArrayCollection;
use FabianFroehlich\Validator\Constraints as Assert;

/**
 * Class Entity
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Tests\Violation\Fixtures
 */
class Entity {

    /**
     * @Assert\IsNull()
     *
     *
     */
    public $shouldBeNull;

    /**
     * @Assert\IsNotNull
     * @Assert\IsId
     *
     * @var int
     */
    public $shouldBeId = 1;

    /**
     * @Assert\IsGreaterThan(bound=3)
     */
    public $isGreaterThan = 0;

    /**
     * @Assert\All(collection=@Assert\Collection(true=@Assert\IsTrue(), false=@Assert\IsFalse()))
     */
    public $array
        = [
            ['true' => true, 'false' => false],
            ['true' => true, 'false' => false],
        ];

    /**
     * @Assert\All(collection=@Assert\Collection(true=@Assert\IsTrue(), false=@Assert\IsFalse()))
     */
    public $collection;

    public function __construct() {
        $this->collection = new ArrayCollection(
            [
                ['true' => true, 'false' => true],
                ['true' => true, 'false' => false],
            ]
        );
    }

}
