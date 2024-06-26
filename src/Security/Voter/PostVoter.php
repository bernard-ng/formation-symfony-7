<?php

namespace App\Security\Voter;

use App\Entity\Post;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class PostVoter extends Voter
{
    public const MUTATE = 'POST_MUTATE';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::MUTATE])
            && $subject instanceof Post;
    }

    /**
     * @param Post $subject
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        /** @var User&UserInterface $user */
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        if ($attribute === self::MUTATE) {
            return $subject->getAuthor() === $user;
        }

        return false;
    }
}
