<?php

namespace App\Events;

use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

class UserChangedEmail extends Event
{
    public const NAME = 'user.changed-email';

    public function __construct(public readonly User $user, public readonly string $token)
    {
    }
}
