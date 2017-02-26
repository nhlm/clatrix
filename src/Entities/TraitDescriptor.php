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

/**
 * Class TraitDescriptor
 * @package Clatrix\Entities
 */
class TraitDescriptor implements DescriptorInterface
{
    /**
     * @var string
     */
    protected $traitName;
    protected $options = [];

    /**
     * TraitDescriptor constructor.
     * @param string $traitName
     * @param array $options
     */
    public function __construct(string $traitName, array $options = [])
    {
        $this->traitName = $traitName;
        $this->options = $options;
    }

    /**
     * returns the code snipped to embed.
     *
     * @return string
     */
    public function getCode(): string
    {
        if ( ! empty($this->options) ) {
            return "use {$this->traitName} { ".join('; ', $this->options).'; }';
        }

        return "use {$this->traitName};";
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