<?php
/*
 * This file is part of the Expense project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Guennichi\ResourceBundle\Repository\ORM;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Guennichi\ResourceBundle\Repository\AbstractResourceRepository;

/**
 * @property EntityManagerInterface $objectManager
 */
class EntityResourceRepository extends AbstractResourceRepository
{
    public function createQueryBuilder(string $alias, ?string $indexBy = null): QueryBuilder
    {
        return $this->objectManager->createQueryBuilder()
            ->select($alias)
            ->from($this->resourceClassName, $alias, $indexBy);
    }

    public function count(): int
    {
        return (int) $this->createQueryBuilder('o')
            ->select('COUNT(o.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findAll(): array
    {
        return $this->findBy([]);
    }

    public function findBy(array $criteria, array $orderBy = null, int $limit = null, int $offset = null): array
    {
        return $this->objectManager
            ->getUnitOfWork()
            ->getEntityPersister($this->resourceClassName)
            ->loadAll($criteria, $orderBy, $limit, $offset);
    }

    public function findOneBy(array $criteria, array $orderBy = []): ?object
    {
        return $this->objectManager
            ->getUnitOfWork()
            ->getEntityPersister($this->resourceClassName)
            ->load($criteria, null, null, $orderBy, 0, 1);
    }
}
