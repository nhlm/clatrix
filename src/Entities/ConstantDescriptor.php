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
 * Class ConstantDescriptor
 * @package Clatrix\Entities
 */
class ConstantDescriptor implements DescriptorInterface
{
    /**
     * @var
     */
    protected $name;

    /**
     * @var ValueEntityInterface
     */
    protected $value;

    /**
     * @var string
     */
    protected $visibility;

    /**
     * ConstantDescriptor constructor.
     * @param $name
     * @param ValueEntityInterface $value
     * @param string|null $visibility
     */
    public function __construct($name, ValueEntityInterface $value, string $visibility = null)
    {
        $this->name = $name;
        $this->value = $value;
        $this->visibility = ( $visibility === 'public' ? '' : $visibility ) ?? '';
    }

    /**
     * returns the code snipped to embed.
     *
     * @return string
     */
    public function getCode(): string
    {
        if ( ! empty($this->visibility) ) {
            return "{$this->visibility} const {$this->name} = ".$this->value->getCode();
        }

        return "const {$this->name} = ".$this->value->getCode();
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