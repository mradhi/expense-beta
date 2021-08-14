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

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SectionExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('section', [SectionRuntime::class, 'renderSection'], ['is_safe' => ['html']])
        ];
    }
}
