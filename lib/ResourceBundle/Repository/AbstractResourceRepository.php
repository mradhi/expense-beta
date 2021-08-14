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
use Doctrine\Persistence\ObjectManager;
use Guennichi\ResourceBundle\Model\ResourceInterface;

abstract class AbstractResourceRepository implements ResourceRepositoryInterface
{
    protected ObjectManager $objectManager;

    protected string $resourceClassName;

    public function setDependencies(string $resourceClassName, ManagerRegistry $managerRegistry): void
    {
        $this->resourceClassName = $resourceClassName;
        $this->objectManager = $managerRegistry->getManagerForClass($resourceClassName);
    }

    public function add(ResourceInterface $resource): void
    {
        $this->objectManager->persist($resource);
    }

    public function remove(ResourceInterface $resource): void
    {
        $this->objectManager->remove($resource);
    }

    public function findById(int|string|null $resourceId): ?object
    {
        return (null !== $resourceId) ? $this->objectManager->find($this->resourceClassName, $resourceId) : null;
    }
}
