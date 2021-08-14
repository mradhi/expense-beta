<?php
/*
 * This file is part of the Expense project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repository;

use App\Model\User;
use Guennichi\ResourceBundle\Repository\ORM\EntityResourceRepository;

class UserRepository extends EntityResourceRepository
{
    public function findByEmail(?string $email): ?User
    {
        return $this->findOneBy(['email' => $email]);
    }
}
