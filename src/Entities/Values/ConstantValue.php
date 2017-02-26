<?php
/**
 * This file is part of the Nihylum's Class Matrix Project.
 *
 * (c)2017 Matthias Kaschubowski
 *
 * This code is licensed under the MIT license,
 * a copy of the license is stored at the project root.
 */

namespace Clatrix\Entities\Values;


use Clatrix\Exceptions\InvalidValueException;
use Clatrix\ValueEntityInterface;

/**
 * Class ConstantValue
 * @package Clatrix\Entities\Values
 */
class ConstantValue implements ValueEntityInterface
{
    use ValueFactoryTrait;

    /**
     * @var string
     */
    protected $constantName;

    /**
     * ConstantValue constructor.
     * @param string $constantName
     * @throws InvalidValueException
     */
    public function __construct(string $constantName)
    {
        if ( ! defined($constantName) ) {
            throw new InvalidValueException(
                'Unknown constant with name: '.$constantName
            );
        }

        $this->constantName = $constantName;
    }

    /**
     * returns the entity definition code.
     *
     * @return string
     */
    public function getCode(): string
    {
        return $this->constantName;
    }

}