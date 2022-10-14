<?php

namespace App\Listeners;

use App\Events\ContactFormSubmitted;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: ContactFormSubmitted::class, method: 'onContactFormSubmitted')]
class SendContactFormEmailListener extends SendEmailListener
{
    protected const EMAIL_SUBJECT = 'Message from Biznews!';

    public function onContactFormSubmitted(ContactFormSubmitted $event): void
    {
        $this->send($event->formData['email'], 'emails/message.html.twig', [
            'name' => $event->formData['name'],
            'email' => $event->formData['email'],
            'subject' => $event->formData['subject'],
            'message' => $event->formData['message'],
        ]);
    }
}
