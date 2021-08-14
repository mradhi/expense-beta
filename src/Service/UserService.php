<?php
/*
 * This file is part of the Expense project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service;

use App\Model\User;
use App\Repository\UserRepository;
use App\Util\UserCanonicalUpdater;
use App\Util\UserPasswordUpdater;
use Guennichi\ResourceBundle\Manager\ResourceManagerInterface;

class UserService
{
    public function __construct(
        private UserRepository $userRepository,
        private UserCanonicalUpdater $canonicalUpdater,
        private UserPasswordUpdater $passwordUpdater,
        private ResourceManagerInterface $resourceManager
    )
    {
    }

    public function findUserByEmail(?string $email): ?User
    {
        return $this->userRepository->findByEmail(
            $this->canonicalUpdater->canonicalizeEmail($email)
        );
    }

    public function update(User $user): void
    {
        // Update canonical fields
        $this->canonicalUpdater->updateCanonicalFields($user);
        // Update password
        $this->passwordUpdater->updatePassword($user);
        // Save user inside DB
        $this->resourceManager->importAndFlush($user);
    }
}
