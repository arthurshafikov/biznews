<?php

namespace App\Controller;

use App\Form\ContactFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact', methods: ['GET'])]
    public function index(): Response
    {
        return $this->returnContactFormResponse($this->createForm(ContactFormType::class));
    }

    private function returnContactFormResponse(FormInterface $form): Response
    {
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
