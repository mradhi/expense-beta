<?php
/*
 * This file is part of the Expense project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Util;

use App\Model\User;

final class UserCanonicalUpdater
{
    public function __construct(private CanonicalizerInterface $emailCanonicalizer)
    {
    }

    public function updateCanonicalFields(User $user): void
    {
        $user->setEmail(
            $this->canonicalizeEmail($user->getEmail())
        );

        // We may add additional fields later ...
    }

    public function canonicalizeEmail(?string $email): ?string
    {
        return $this->emailCanonicalizer->canonicalize($email);
    }
}
