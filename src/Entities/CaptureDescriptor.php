<?php
/**
 * This file is part of the Nihylum's Class Matrix Project.
 *
 * (c)2017 Matthias Kaschubowski
 *
 * This code is licensed under the MIT license,
 * a copy of the license is stored at the project root.
 */

namespace Clatrix\Entities;


use Clatrix\DescriptorInterface;
use Clatrix\MethodRegistry;

/**
 * Class CaptureDescriptor
 * @package Clatrix\Entities
 */
class CaptureDescriptor implements DescriptorInterface
{
    /**
     * @var callable
     */
    protected $callable;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $visibility;

    /**
     * @var array
     */
    protected $parameters;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var \ReflectionType|null
     */
    protected $returnType;

    /**
     * CaptureDescriptor constructor.
     * @param string $name
     * @param callable $callable
     * @param string $visibility
     */
    public function __construct(string $name, callable $callable, string $visibility = null)
    {
        $this->name = $name;
        $this->callable = $callable;
        $this->visibility = $visibility ?? 'public';
        $this->id = uniqid('cptr_', true);

        list($this->returnType, $this->parameters) = $this->extractParametersAndReturnType($callable);

        MethodRegistry::getInstance()->set($this->id, $this->name, $callable);
    }

    /**
     * returns the code snipped to embed.
     *
     * @return string
     */
    public function getCode(): string
    {
        $registry = MethodRegistry::class;
        $signatureParts = [];

        foreach ( $this->parameters as $current ) {
            $signatureParts[] = $this->marshalParameterSignature($current);
        }

        $signature = join(', ', $signatureParts);

        $returnType = $this->returnType === null ? '' : ': '.$this->returnType;

        return "{$this->visibility} function {$this->name}({$signature}){$returnType}".
            "{ return call_user_func_array(\\{$registry}::getInstance()->get('{$this->id}', '{$this->name}'), func_get_args()); }"
        ;
    }

    /**
     * returns the extractable code entities.
     *
     * @return array
     */
    public function getCodeEntities(): array
    {
        return [];
    }

    /**
     * extracts the parameters of the provided callable.
     *
     * @param callable $callable
     * @return array
     */
    protected function extractParametersAndReturnType(callable $callable): array
    {
        if ( version_compare(PHP_VERSION, "7.1.0", ">=") ) {
            $reflection = new \ReflectionFunction(
                \Closure::fromCallable($callable)
            );
        }
        else if ( $callable instanceof \Closure ) {
            $reflection = new \ReflectionFunction($callable);
        }
        else if ( is_string($callable) && false !== strpos($callable, '::') ) {
            list($class, $method) = explode('::', $callable);
            $reflection = new \ReflectionMethod($class, $method);
        }
        else if ( is_string($callable) && false === strpos($callable, '::') ) {
            $reflection = new \ReflectionFunction($callable);
        }
        else if ( is_array($callable) ) {
            list($class, $method) = $callable;
            $reflection = new \ReflectionMethod($class, $method);
        }
        else {
            $reflection = new \ReflectionMethod($callable, '__invoke');
        }

        return [
            $reflection->getReturnType(),
            $reflection->getParameters(),
        ];
    }

    /**
     * marshals a parameter signature snippet.
     *
     * @param \ReflectionParameter $parameter
     * @return string
     */
    protected function marshalParameterSignature(\ReflectionParameter $parameter): string
    {
        $stack = [];

        if ( $parameter->getClass() ) {
            $stack[0] = $parameter->getClass()->getName();
        }

        if ( $parameter->hasType() ) {
            $stack[0] = (string) $parameter->getType();
        }

        if ( $parameter->isArray() ) {
            $stack[0] = 'array';
        }

        if ( $parameter->isVariadic() ) {
            $stack[1] = '...';
        }

        $stack[2] = ( $parameter->isPassedByReference() ? '&' : '' ).$parameter->getName();

        if ( $parameter->isOptional() ) {
            $stack[3] = '=';
        }

        if ( $parameter->isOptional() && $parameter->isDefaultValueConstant() ) {
            $stack[4] = $parameter->getDefaultValueConstantName();
        }

        if ( $parameter->isOptional() && ! $parameter->isDefaultValueConstant() ) {
            $stack[4] = is_string($parameter->getDefaultValue())
                ? sprintf('"%s"', $parameter->getDefaultValue())
                : $parameter->getDefaultValue()
            ;
        }

        return join(' ', array_filter($stack));
    }
}