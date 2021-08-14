<?php
/*
 * This file is part of the Expense project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Guennichi\ResourceBundle\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Guennichi\ResourceBundle\Model\ResourceInterface;

interface ResourceRepositoryInterface
{
    public function setDependencies(string $resourceClassName, ManagerRegistry $managerRegistry): void;

    public function add(ResourceInterface $resource): void;

    public function remove(ResourceInterface $resource): void;

    public function findAll(): array;

    public function findBy(array $criteria, array $orderBy = null, int $limit = null, int $offset = null): array;

    public function findById(int|string|null $resourceId): ?object;

    public function count(): int;

    public function findOneBy(array $criteria, array $orderBy = []): ?object;
}
