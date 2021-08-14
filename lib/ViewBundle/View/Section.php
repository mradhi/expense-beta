<?php
/*
 * This file is part of the Expense project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Guennichi\ViewBundle\View;

abstract class Section
{
    public function __construct(protected ?string $name = null)
    {
    }

    public function builtBy(): string
    {
        return static::class . 'Builder';
    }

    public function getName(): string
    {
        return $this->name ?? spl_object_hash($this);
    }
}
