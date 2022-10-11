<?php

namespace App\Events;

use App\Entity\SubscribedEmail;
use Symfony\Contracts\EventDispatcher\Event;

class SubscribedEmailCreated extends Event
{
    public const NAME = 'subscribe-email.created';

    public function __construct(public readonly SubscribedEmail $subscribedEmail, public readonly string $token)
    {
    }
}
