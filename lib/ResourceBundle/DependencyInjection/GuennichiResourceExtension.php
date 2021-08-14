<?php
/*
 * This file is part of the Expense project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Guennichi\ResourceBundle\DependencyInjection;

use Guennichi\ResourceBundle\Attribute\Resource;
use Guennichi\ResourceBundle\Factory\AbstractResourceFactory;
use Guennichi\ResourceBundle\Factory\ResourceFactory;
use Guennichi\ResourceBundle\Factory\ResourceFactoryInterface;
use Guennichi\ResourceBundle\Model\ResourceInterface;
use Guennichi\ResourceBundle\Repository\ResourceRepositoryInterface;
use ReflectionClass;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Finder\Finder;
use Webmozart\Assert\Assert;
use function Symfony\Component\String\u;

class GuennichiResourceExtension extends Extension
{
    /**
     * @inheritDoc
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $processor = new Processor();
        $configuration = new Configuration();
        $config = $processor->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        $this->registerResourceMetadata($container, $config);
    }

    private function registerResourceMetadata(ContainerBuilder $container, array $config): void
    {
        $projectDir = $container->getParameter('kernel.project_dir');
        $finder = Finder::create()
            ->files()
            ->in($projectDir . $config['path'])
            ->name('*.php')
            ->notName('*Interface.php')
            ->notName('*Trait.php');

        $resources = [];
        foreach ($finder as $file) {
            $classname = u($file->getRealPath())
                ->replace($projectDir . '/src', $config['namespace'])
                ->replace('/', '\\')
                ->replace('.php', '')
                ->toString();

            $reflectionClass = new ReflectionClass($classname);
            if (!$reflectionClass->isInstantiable() || !$reflectionClass->implementsInterface(ResourceInterface::class)) {
                // ignore
                continue;
            }

            $attributes = $reflectionClass->getAttributes(Resource::class);
            if (false !== $attribute = reset($attributes)) {
                /** @var Resource $metadata */
                $metadata = $attribute->newInstance();
                $alias = u($classname)
                    ->snake()
                    ->toString();

                if (null !== $metadata->repository) {
                    Assert::subclassOf($metadata->repository, ResourceRepositoryInterface::class);
                }

                if (null !== $metadata->factory) {
                    Assert::subclassOf($metadata->factory, ResourceFactoryInterface::class);
                }

                // Register resource
                $resources[$alias] = [
                    'model' => $classname,
                    'repository' => $metadata->repository,
                    'factory' => $metadata->factory
                ];
            }
        }

        $container->setParameter('guennichi.resources', $resources);
    }
}
