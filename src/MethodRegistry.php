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
 * Class MethodRegistry
 * @package Clatrix
 */
final class MethodRegistry
{
    /**
     * @var callable[]
     */
    private $callables = [];

    /**
     * callable getter.
     *
     * @param string $hash
     * @param string $method
     * @return callable
     */
    public function get(string $hash, string $method): callable
    {
        $key = $this->marshalKey($hash, $method);

        if ( ! array_key_exists($key, $this->callables) ) {
            throw new \RuntimeException(
                'No method know for object '.$hash.' and method '.$method.'()'
            );
        }

        return $this->callables[$key];
    }

    /**
     * callable setter.
     *
     * @param string $hash
     * @param string $method
     * @param callable $callable
     */
    public function set(string $hash, string $method, callable $callable)
    {
        $this->callables[$this->marshalKey($hash, $method)] = $callable;
    }

    /**
     * static singleton implementation.
     *
     * @return MethodRegistry
     */
    public static function getInstance(): MethodRegistry
    {
        static $instance;

        if ( ! $instance instanceof MethodRegistry ) {
            $instance = new static;
        }

        return $instance;
    }

    /**
     * marshals a key for a given hash and method.
     *
     * @param string $hash
     * @param string $method
     * @return string
     */
    private function marshalKey(string $hash, string $method): string
    {
        return sprintf('%s::%s', strtolower($hash), strtolower($method));
    }
}