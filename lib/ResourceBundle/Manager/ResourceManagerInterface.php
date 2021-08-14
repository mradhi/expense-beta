<?php
/*
 * This file is part of the Expense project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Guennichi\ResourceBundle\Manager;

use Guennichi\ResourceBundle\Model\ResourceInterface;

interface ResourceManagerInterface
{
    public function import(ResourceInterface $resource): void;

    public function importAndFlush(ResourceInterface $resource): void;

    public function delete(ResourceInterface $resource): void;

    public function deleteAndFlush(ResourceInterface $resource): void;

    public function flush(): void;
}
