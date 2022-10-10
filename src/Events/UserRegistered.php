<?php

namespace App\Events;

use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

class UserRegistered extends Event
{
    public const NAME = 'user.registered';

    public function __construct(public readonly User $user, public readonly string $token)
    {
    }
}
