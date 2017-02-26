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


use Clatrix\Entities\CaptureDescriptor;
use Clatrix\Entities\ConstantDescriptor;
use Clatrix\Entities\PropertyDescriptor;
use Clatrix\Entities\TraitDescriptor;

/**
 * Class ClassMatrix
 * @package Clatrix
 */
class ClassMatrix implements ClassMatrixInterface
{
    /**
     * @var null|string
     */
    protected $parentClass = null;
    /**
     * @var DescriptorInterface[]|TraitDescriptor[]
     */
    protected $traits = [];
    /**
     * @var string[]
     */
    protected $interfaces = [];
    /**
     * @var DescriptorInterface[]|CaptureDescriptor[]
     */
    protected $captures = [];
    /**
     * @var DescriptorInterface[]|PropertyDescriptor[]
     */
    protected $properties = [];
    /**
     * @var DescriptorInterface[]|ConstantDescriptor[]
     */
    protected $constants = [];
    /**
     * @var callable
     */
    protected $remainingMethodCallback;

    /**
     * sets the class name to extend from.
     *
     * @param string $className
     * @return ClassMatrixInterface
     */
    public function inheritFrom(string $className): ClassMatrixInterface
    {
        $this->parentClass = $className;

        return $this;
    }

    /**
     * sets the collection of traits to implement. Existing traits are replaced with the provided set of traits.
     *
     * @param \string[] ...$traits
     * @return ClassMatrixInterface
     */
    public function withTraits(string ... $traits): ClassMatrixInterface
    {
        $this->traits = [];

        foreach ( $traits as $current ) {
            $this->withTrait($current);
        }

        return $this;
    }

    /**
     * adds a trait with the provided changes.
     *
     * @param string $trait
     * @param array $changes
     * @return ClassMatrixInterface
     */
    public function withTrait(string $trait, array $changes = []): ClassMatrixInterface
    {
        $this->traits[$trait] = new TraitDescriptor($trait, $changes);

        return $this;
    }

    /**
     * sets the collection of interfaces to implement. Existing interfaces are replaced with the provided set of
     * interfaces.
     *
     * @param \string[] ...$interfaces
     * @return ClassMatrixInterface
     */
    public function withInterfaces(string ... $interfaces): ClassMatrixInterface
    {
        $this->interfaces = $interfaces;

        return $this;
    }

    /**
     * adds a method by inheriting the method signature and return type from the provided callback and the optional
     * provided visibility.
     *
     * @param string $method
     * @param callable $callback
     * @param string|null $visibility
     * @return ClassMatrixInterface
     */
    public function withCapture(string $method, callable $callback, string $visibility = null): ClassMatrixInterface
    {
        $this->captures[$method] = new CaptureDescriptor($method, $callback, $visibility);

        return $this;
    }

    /**
     * fills the remaining methods with a capture by the provided callable.
     *
     * @param callable $callback
     * @return ClassMatrixInterface
     */
    public function withRemainingAbstractsCapture(callable $callback): ClassMatrixInterface
    {
        $this->remainingMethodCallback = $callback;

        return $this;
    }

    /**
     * attaches a constant to the class.
     *
     * @param string $name
     * @param ValueEntityInterface $value
     * @param string|null $visibility
     * @return ClassMatrixInterface
     */
    public function withConstant(string $name, ValueEntityInterface $value, string $visibility = null): ClassMatrixInterface
    {
        $this->constants[$name] = new ConstantDescriptor($name, $value, $visibility);

        return $this;
    }

    /**
     * attaches a property to the class.
     *
     * @param string $name
     * @param ValueEntityInterface $value
     * @param string|null $visibility
     * @return ClassMatrixInterface
     */
    public function withProperty(string $name, ValueEntityInterface $value, string $visibility = null): ClassMatrixInterface
    {
        $this->properties[$name] = new PropertyDescriptor($name, $visibility, $value);

        return $this;
    }

    /**
     * returns the executable code (for eval).
     *
     * @return string
     */
    public function getExecutableCode(): string
    {
        $class = 'return new class(... $parameters) ';

        if ( $this->parentClass ) {
            $class .= 'extends '.$this->parentClass.' ';
        }

        if ( ! empty($this->interfaces) ) {
            $class .= 'implements '.join(', ', $this->interfaces).' ';
        }

        $class .= '{';

        if ( ! empty($this->traits) ) {
            foreach ( $this->traits as $current ) {
                $class .= $current->getCode().' ';
            }
        }

        if ( ! empty($this->constants) ) {
            foreach ( $this->constants as $current ) {
                $class .= $current->getCode().' ';
            }
        }

        if ( ! empty($this->properties) ) {
            foreach ( $this->properties as $current ) {
                $class .= $current->getCode().' ';
            }
        }

        if ( ! empty($this->captures) ) {
            foreach ( $this->captures as $current ) {
                $class .= $current->getCode().' ';
            }
        }

        return $class.'};';
    }

}