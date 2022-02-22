<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\Task;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\CacheableVoterInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class TaskVoter implements CacheableVoterInterface
{
    /** @phpstan-ignore-next-line */
    public function vote(TokenInterface $token, mixed $subject, array $attributes): int
    {
        /* @phpstan-ignore-next-line */
        if ($token->getUser() === $subject->getAuthor()
        /* @phpstan-ignore-next-line */
        || (in_array('ROLE_ADMIN', $token->getUser()->getRoles(), true)
        /* @phpstan-ignore-next-line */
        && 'anonyme' === $subject->getAuthor()->getUserName())
        ) {
            return VoterInterface::ACCESS_GRANTED;
        }

        return VoterInterface::ACCESS_DENIED;
    }

    public function supportsAttribute(string $attribute): bool
    {
        return true;
    }

    public function supportsType(string $subjectType): bool
    {
        return Task::class === $subjectType;
    }
}
