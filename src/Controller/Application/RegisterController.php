<?php
/*
 * This file is part of the Expense project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Application;

use App\Controller\AbstractController;
use App\Factory\UserFactory;
use App\Form\RegisterType;
use App\Service\UserService;
use App\View\RegisterFormSection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    #[Route('/register', name: 'application_register')]
    public function __invoke(Request $request, UserFactory $userFactory, UserService $userService): Response
    {
        $form = $this->createForm(RegisterType::class, $user = $userFactory->createNew());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userService->update($user);
            // Login user manually
            // Redirect to his account space
            return $this->redirectToRoute('');
        }

        return $this->render('application/public/pages/home.html.twig', [
            '_register_form' => new RegisterFormSection($form)
        ]);
    }
}
