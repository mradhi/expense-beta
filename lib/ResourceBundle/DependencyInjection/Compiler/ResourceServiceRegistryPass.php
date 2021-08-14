<?php
/*
 * This file is part of the Expense project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Guennichi\ResourceBundle\DependencyInjection\Compiler;

use Guennichi\ResourceBundle\Factory\AbstractResourceFactory;
use Guennichi\ResourceBundle\Factory\ResourceFactory;
use ReflectionClass;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class ResourceServiceRegistryPass implements CompilerPassInterface
{
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container): void
    {
        foreach ($container->getParameter('guennichi.resources') as $alias => $attrs) {
            if (null !== $attrs['repository']) {
                // Register resource repository as a service
                $container->getDefinition($attrs['repository'])
                    ->addMethodCall('setDependencies', [
                        $attrs['model'],
                        new Reference('doctrine', ContainerInterface::IGNORE_ON_INVALID_REFERENCE)
                    ]);
            }

            // Register resource base factory as an internal service
            $baseFactory = new Definition(ResourceFactory::class, [$attrs['model']]);
            $container->setDefinition($baseFactoryId = "guennichi.resource.$alias.factory", $baseFactory);

            if (null !== $attrs['factory']) {
                $factoryDefinition = $container->getDefinition($attrs['factory']);

                // Register resource main factory as a service
                $factory = new ReflectionClass($attrs['factory']);
                if ($factory->isSubclassOf(AbstractResourceFactory::class)) {
                    $factoryDefinition->addMethodCall('setInnerFactory', [new Reference($baseFactoryId)]);
                    continue;
                }
                // The factory here is an instance of ResourceFactoryInterface
                $container->getDefinition($attrs['factory'])
                    ->setArguments([new Reference($baseFactoryId)]);
            }
        }
    }
}
