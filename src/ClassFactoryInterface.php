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
 * Interface ClassFactoryInterface
 * @package Clatrix
 */
interface ClassFactoryInterface
{
    /**
     * dispenses a new class matrix with an optionally applied parent class.
     *
     * @param string|object|null $parentClass
     * @return ClassMatrixInterface
     */
    public function dispense($parentClass = null): ClassMatrixInterface;

    /**
     * prototypes a new class matrix for the provided alias and an optionally applied parent class.
     *
     * @param string $alias
     * @param string|object|null $parentClass
     * @return ClassMatrixInterface
     */
    public function prototype(string $alias, $parentClass = null): ClassMatrixInterface;

    /**
     * incubates a previously stored alias.
     *
     * @param string $alias
     * @param mixed ...$parameters
     * @return mixed
     */
    public function incubate(string $alias, ... $parameters);

    /**
     * makes an class instance from the provided class matrix.
     *
     * @param ClassMatrixInterface $matrix
     * @param mixed[] ...$parameters
     * @return mixed
     */
    public function make(ClassMatrixInterface $matrix, ... $parameters);
}