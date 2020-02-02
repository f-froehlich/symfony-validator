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

use FabianFroehlich\Validator\Constraints\AbstractConstraint;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class AbstractConstraintViolationBuilder
 * Abstract implementation of {@link ConstraintViolationBuilderInterface}.
 *
 * @author  Fabian Fröhlich <mail@f-froehlich.de>
 * @package FabianFroehlich\Validator\Violation
 *
 */
abstract class AbstractConstraintViolationBuilder
    implements ConstraintViolationBuilderInterface {

    /** @var ConstraintViolationList */
    protected $violationList;

    /** @var string */
    protected $propertyPath;

    /** @var TranslatorInterface */
    private $translator;


    /**
     * AbstractConstraintViolationBuilder constructor.
     *
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator) {

        $this->reset();
        $this->translator = $translator;
    }

    /**
     * {@inheritDoc}
     */
    public function reset(): void {

        $this->propertyPath  = '';
        $this->violationList = new ConstraintViolationList();
    }

    /**
     * {@inheritdoc}
     */
    public function setPath(string $path): ConstraintViolationBuilderInterface {

        $this->propertyPath = $path;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getPath(): string {

        return $this->propertyPath;
    }

    /**
     * {@inheritdoc}
     */
    public function addViolation(
        $invalidValue,
        string $code,
        array $params,
        AbstractConstraint $constraint
    ): ConstraintViolationBuilderInterface {

        $this->violationList->add(
            new ConstraintViolation(
                $this->translator->trans($code, $params, $constraint->getTranslationDomain()),
                $this->propertyPath,
                $invalidValue,
                $code,
                $constraint
            )
        );

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getViolations(): array {

        return $this->violationList->getAll();
    }

    /**
     * {@inheritDoc}
     */
    public function getViolationList(): ConstraintViolationList {

        return $this->violationList;
    }

}
