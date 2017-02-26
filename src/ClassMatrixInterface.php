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
 * Interface ClassMatrixInterface
 * @package Clatrix
 */
interface ClassMatrixInterface
{
    /**
     * marks a visibility as public
     */
    const AS_PUBLIC = 'public';

    /**
     * marks a visibility as protected
     */
    const AS_PROTECTED = 'protected';

    /**
     * marks a visibility as private
     */
    const AS_PRIVATE = 'private';

    /**
     * sets the class name to extend from.
     *
     * @param string $className
     * @return ClassMatrixInterface
     */
    public function inheritFrom(string $className): ClassMatrixInterface;

    /**
     * sets the collection of traits to implement. Existing traits are replaced with the provided set of traits.
     *
     * @param \string[] ...$traits
     * @return ClassMatrixInterface
     */
    public function withTraits(string ... $traits): ClassMatrixInterface;

    /**
     * adds a trait with the provided changes.
     *
     * @param string $trait
     * @param array $changes
     * @return ClassMatrixInterface
     */
    public function withTrait(string $trait, array $changes = []): ClassMatrixInterface;

    /**
     * sets the collection of interfaces to implement. Existing interfaces are replaced with the provided set of
     * interfaces.
     *
     * @param \string[] ...$interfaces
     * @return ClassMatrixInterface
     */
    public function withInterfaces(string ... $interfaces): ClassMatrixInterface;

    /**
     * adds a method by inheriting the method signature and return type from the provided callback and the optional
     * provided visibility.
     *
     * @param string $method
     * @param callable $callback
     * @param string|null $visibility
     * @return ClassMatrixInterface
     */
    public function withCapture(string $method, callable $callback, string $visibility = null): ClassMatrixInterface;

    /**
     * fills the remaining abstract methods with a capture by the provided callable.
     *
     * @param callable $callback
     * @return ClassMatrixInterface
     */
    public function withRemainingAbstractsCapture(callable $callback): ClassMatrixInterface;

    /**
     * attaches a constant to the class.
     *
     * @param string $name
     * @param ValueEntityInterface $value
     * @param string|null $visibility
     * @return ClassMatrixInterface
     */
    public function withConstant(string $name, ValueEntityInterface $value,  string $visibility = null): ClassMatrixInterface;

    /**
     * attaches a property to the class.
     *
     * @param string $name
     * @param ValueEntityInterface $value
     * @param string|null $visibility
     * @return ClassMatrixInterface
     */
    public function withProperty(string $name, ValueEntityInterface $value, string $visibility = null): ClassMatrixInterface;

    /**
     * returns the executable code (for eval).
     *
     * @return string
     */
    public function getExecutableCode(): string;
}