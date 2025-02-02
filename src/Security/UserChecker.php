<?php

namespace App\Security;

use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\User;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof User) {
            return;
        }

        dd($user);

        if (!$user->isVerified()) {
            throw new CustomUserMessageAccountStatusException('Votre compte n\'a pas encore été vérifié.');
        }
    }

    public function checkPostAuth(UserInterface $user): void
    {
        // Pas besoin de vérifications supplémentaires après authentification
    }
}
