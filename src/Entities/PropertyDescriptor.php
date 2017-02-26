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
use Clatrix\ValueEntityInterface;

/**
 * Class PropertyDescriptor
 * @package Clatrix\Entities
 */
class PropertyDescriptor implements DescriptorInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $visibility;

    /**
     * @var ValueEntityInterface
     */
    protected $value;

    /**
     * PropertyDescriptor constructor.
     * @param string $name
     * @param string $visibility
     * @param ValueEntityInterface|null $value
     */
    public function __construct(string $name, string $visibility, ValueEntityInterface $value = null)
    {
        $this->name = $name;
        $this->visibility = $visibility;
        $this->value = $value;
    }

    /**
     * returns the code snipped to embed.
     *
     * @return string
     */
    public function getCode(): string
    {
        return "{$this->visibility} \${$this->name}".( $this->value ? ' = '.$this->value->getCode() : '' );
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

}