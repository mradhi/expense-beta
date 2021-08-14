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

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Guennichi\ResourceBundle\Model\ResourceInterface;

class ResourceManager implements ResourceManagerInterface
{
    protected ObjectManager $objectManager;

    public function __construct(ManagerRegistry $managerRegistry, string $managerName = null)
    {
        $this->objectManager = $managerRegistry->getManager($managerName);
    }

    public function getObjectManager(): ObjectManager
    {
        return $this->objectManager;
    }

    public function import(ResourceInterface $resource): void
    {
        // Persist if it's a new resource
        if (null === $resource->getId()) {
            $this->objectManager->persist($resource);
        }
    }

    public function importAndFlush(ResourceInterface $resource): void
    {
        $this->import($resource);
        $this->objectManager->flush();
    }

    public function delete(ResourceInterface $resource): void
    {
        $this->objectManager->remove($resource);
    }

    public function deleteAndFlush(ResourceInterface $resource): void
    {
        $this->objectManager->remove($resource);
        $this->objectManager->flush();
    }

    public function flush(): void
    {
        $this->objectManager->flush();
    }
}
