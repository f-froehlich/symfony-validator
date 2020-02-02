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

namespace FabianFroehlich\Validator\Constraints;


use FabianFroehlich\Validator\Exception\ConstraintDefinitionException;
use FabianFroehlich\Validator\Validator\ExpressionValidator;

/**
 * Class Expression
 *
 * @Annotation
 * @Target({"PROPERTY", "ANNOTATION"})
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Constraints
 */
class Expression
    extends AbstractConstraint {

    /** @var string */
    public $expression;

    /**
     * Expression constructor.
     *
     * @param string|array $expression
     */
    public function __construct($expression = '') {
        if (is_array($expression)) {
            if (!array_key_exists('expression', $expression)) {
                throw new ConstraintDefinitionException('Key \'expression\' must be set');
            }
            $expression = $expression['expression'];
        }

        if (!is_string($expression)) {
            throw new ConstraintDefinitionException('Expression must be string');
        }

        $this->expression = $expression;
    }

    /**
     * {@inheritDoc}
     */
    public function validatedBy(): string {

        return ExpressionValidator::class;
    }

    /**
     * @inheritDoc
     */
    public function getTranslationDomain(): string {
        return 'Expression';
    }

}
