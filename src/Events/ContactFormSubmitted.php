<?php

namespace App\Events;

use Symfony\Contracts\EventDispatcher\Event;

class ContactFormSubmitted extends Event
{
    public const NAME = 'contact-form.sent';

    public function __construct(public readonly array $formData)
    {
    }
}
