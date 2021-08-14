<?php
/*
 * This file is part of the Expense project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\View;

use App\Aware\TwigEnvironmentAware;
use App\Form\RegisterType;
use Guennichi\ViewBundle\View\Section;
use Guennichi\ViewBundle\View\SectionBuilder;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class RegisterFormSectionBuilder extends SectionBuilder
{
    use TwigEnvironmentAware;

    public function __construct(private FormFactoryInterface $formFactory)
    {
    }

    /**
     * @param RegisterFormSection $section
     * @param Request $request
     *
     * @return string
     */
    public function build(Section $section, Request $request): string
    {
        $form = $section->getRegisterForm() ?? $this->formFactory->create(RegisterType::class);

        return $this->render('application/section/_register_form.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
