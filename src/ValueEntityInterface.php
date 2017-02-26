<?php
/**
 * This file is part of the Nihylum's Class Matrix Project.
 *
 * (c)2017 Matthias Kaschubowski
 *
 * This code is licensed under the MIT license,
 * a copy of the license is stored at the project root.
 */

namespace Clatrix;


interface ValueEntityInterface
{
    /**
     * returns the entity definition code.
     *
     * @return string
     */
    public function getCode(): string;

    /**
     * factory method.
     *
     * @param $variant
     * @return ValueEntityInterface
     */
    public static function create($variant): ValueEntityInterface;
}