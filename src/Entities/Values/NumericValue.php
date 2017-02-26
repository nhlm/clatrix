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


use Clatrix\Exceptions\ClatrixException;
use Clatrix\ValueEntityInterface;

/**
 * Class NumericValue
 * @package Clatrix\Entities\Values
 */
class NumericValue implements ValueEntityInterface
{
    use ValueFactoryTrait;

    /**
     * @var float
     */
    protected $number;

    /**
     * NumericValue constructor.
     * @param $number
     * @throws ClatrixException
     */
    public function __construct($number)
    {
        if ( ! is_numeric($number) ) {
            throw new ClatrixException(
                'provided value must be numeric'
            );
        }

        $this->number = (float) $number;
    }

    /**
     * returns the entity definition code.
     *
     * @return string
     */
    public function getCode(): string
    {
        return (string) $this->number;
    }

}