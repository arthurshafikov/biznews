<?php

namespace App\Controller;

use App\Events\ContactFormSubmitted;
use App\Form\ContactFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    public function __construct(
        protected readonly EventDispatcherInterface $eventDispatcher
    ) {
    }

    #[Route('/contact', name: 'app_contact', methods: ['GET'])]
    public function index(): Response
    {
        return $this->returnContactFormResponse($this->createForm(ContactFormType::class));
    }

    #[Route('/contact', name: 'app_contact_send', methods: ['POST'])]
    public function sendMessage(Request $request): Response
    {
        $contactForm = $this->createForm(ContactFormType::class);
        $contactForm->handleRequest($request);
        if ($contactForm->isValid()) {
            $this->eventDispatcher->dispatch(new ContactFormSubmitted($contactForm->getData()), ContactFormSubmitted::NAME);

            $request->getSession()->getFlashBag()->add('session-message', [
                'message' => 'Email has been sent successfully!',
            ]);
        }

        return $this->returnContactFormResponse($contactForm);
    }

    private function returnContactFormResponse(FormInterface $form): Response
    {
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
