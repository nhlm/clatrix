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

trait ValueFactoryTrait
{
    /**
     * factory method.
     *
     * @param $variant
     * @return ValueEntityInterface
     */
    public static function create($variant): ValueEntityInterface
    {
        return new static($variant);
    }
}