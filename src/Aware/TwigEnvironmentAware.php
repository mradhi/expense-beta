<?php
/*
 * This file is part of the Expense project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Aware;

use Symfony\Contracts\Service\Attribute\Required;
use Twig\Environment;
use Twig\TemplateWrapper;

trait TwigEnvironmentAware
{
    protected Environment $environment;

    #[Required]
    public function setEnvironment(Environment $environment): void
    {
        $this->environment = $environment;
    }

    protected function render(string|TemplateWrapper $name, array $context = []): string
    {
        return $this->environment->render($name, $context);
    }
}
