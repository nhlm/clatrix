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


use Clatrix\Entities\Values\ConstantValue;
use Clatrix\Entities\Values\NumericValue;
use Clatrix\Entities\Values\StringValue;
use Clatrix\Exceptions\MatrixNotFoundException;

/**
 * Class ClassFactory
 * @package Clatrix
 */
class ClassFactory implements ClassFactoryInterface
{
    /**
     * @var array
     */
    protected $prototypes = [];

    /**
     * dispenses a new class matrix with an optionally applied parent class.
     *
     * @param string|object|null $parentClass
     * @return ClassMatrixInterface
     */
    public function dispense($parentClass = null): ClassMatrixInterface
    {
        $matrix = $this->marshalClassMatrix();

        if ( null !== $parentClass ) {
            $matrix->inheritFrom($parentClass);
        }

        return $matrix;
    }

    /**
     * prototypes a new class matrix for the provided alias and an optionally applied parent class.
     *
     * @param string $alias
     * @param string|object|null $parentClass
     * @return ClassMatrixInterface
     */
    public function prototype(string $alias, $parentClass = null): ClassMatrixInterface
    {
        $matrix = $this->marshalClassMatrix();

        if ( null !== $parentClass ) {
            $matrix->inheritFrom($parentClass);
        }

        return $this->prototypes[$this->marshalKey($alias)] = $matrix;
    }

    /**
     * incubates a previously stored alias.
     *
     * @param string $alias
     * @param mixed ...$parameters
     * @throws MatrixNotFoundException when the provided alias is not known to the factory instance
     * @return mixed
     */
    public function incubate(string $alias, ... $parameters)
    {
        $key = $this->marshalKey($alias);

        if ( ! array_key_exists($alias, $this->prototypes) ) {
            throw new MatrixNotFoundException(
                'Unknown Class Matrix: '.$alias
            );
        }

        return $this->make($this->prototypes[$key], ... $parameters);
    }

    /**
     * makes an class instance from the provided class matrix.
     *
     * @param ClassMatrixInterface $matrix
     * @param mixed[] ...$parameters
     * @return mixed
     */
    public function make(ClassMatrixInterface $matrix, ... $parameters)
    {
        $caller = function() use($parameters) {
            /** @var ClassMatrixInterface $this */
            return eval($this->getExecutableCode());
        };

        return call_user_func($caller->bindTo($matrix));
    }

    /**
     * creates a string value representation for the provided string.
     *
     * @param string $value
     * @return StringValue
     */
    public function stringValue(string $value): StringValue
    {
        return new StringValue($value);
    }

    /**
     * creates a numeric value representation for the provided value.
     *
     * @param $value
     * @return NumericValue
     */
    public function numericValue($value): NumericValue
    {
        return new NumericValue($value);
    }

    /**
     * creates a constant value representation for the provided constant.
     *
     * @param string $constantName
     * @return ConstantValue
     */
    public function constantValue(string $constantName): ConstantValue
    {
        return new ConstantValue($constantName);
    }

    /**
     * marshals a prototype alias key.
     *
     * @param string $key
     * @return string
     */
    protected function marshalKey(string $key): string
    {
        return strtolower(str_replace(' ', '_', trim($key)));
    }

    /**
     * marshals a class matrix interface implementation instance.
     *
     * @return ClassMatrixInterface
     */
    protected function marshalClassMatrix(): ClassMatrixInterface
    {
        return new ClassMatrix();
    }
}