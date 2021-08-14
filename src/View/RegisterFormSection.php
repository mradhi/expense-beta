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

use Guennichi\ViewBundle\View\Section;
use Symfony\Component\Form\FormInterface;

class RegisterFormSection extends Section
{
    public function __construct(private ?FormInterface $registerForm = null)
    {
        parent::__construct();
    }

    public function getRegisterForm(): ?FormInterface
    {
        return $this->registerForm;
    }
}
