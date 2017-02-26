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


/**
 * Interface DescriptorInterface
 * @package Clatrix
 */
interface DescriptorInterface
{
    /**
     * returns the code snipped to embed.
     *
     * @return string
     */
    public function getCode(): string;

    /**
     * returns the extractable code entities.
     *
     * @return array
     */
    public function getCodeEntities(): array;
}