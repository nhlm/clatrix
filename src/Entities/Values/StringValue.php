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


use Clatrix\ValueEntityInterface;

/**
 * Class StringValue
 * @package Clatrix\Entities\Values
 */
class StringValue implements ValueEntityInterface
{
    use ValueFactoryTrait;

    /**
     * @var string
     */
    protected $string;

    /**
     * StringValue constructor.
     * @param string $string
     */
    public function __construct(string $string)
    {
        $this->string = $string;
    }

    /**
     * returns the entity definition code.
     *
     * @return string
     */
    public function getCode(): string
    {
        return addslashes($this->string);
    }

}