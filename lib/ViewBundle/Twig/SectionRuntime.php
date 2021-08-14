<?php
/*
 * This file is part of the Expense project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Guennichi\ViewBundle\Twig;

use Guennichi\ViewBundle\View\Section;
use Symfony\Component\DependencyInjection\ServiceLocator;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\RuntimeExtensionInterface;

class SectionRuntime implements RuntimeExtensionInterface
{
    protected array $cache = [];

    public function __construct(
        protected ServiceLocator $serviceLocator,
        protected RequestStack   $requestStack
    )
    {
    }

    public function renderSection(Section $section): ?string
    {
        if (isset($this->cache[$section->getName()])) {
            return $this->cache[$section->getName()];
        }

        if ($this->serviceLocator->has($section->builtBy())) {
            return $this->cache[$section->getName()] = $this->serviceLocator->get($section->builtBy())
                ->build($section, $this->requestStack->getCurrentRequest());
        }

        return null;
    }
}
