<?php

namespace App\Controller;

use App\Form\CommentFormType;
use App\Service\CommentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    #[Route('/posts/comment', name: 'app_comment')]
    public function comment(
        Request $request,
        CommentService $commentService,
    ): Response {
        $commentForm = $this->createForm(CommentFormType::class);
        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $commentService->add($commentForm->getData(), $this->getUser());
            $request->getSession()->getFlashBag()->add('session-message', [
                'message' => 'Comment added successfully!',
            ]);
        }

        return $this->render('post/comment-form.html.twig', [
            'commentForm' => $commentForm->createView(),
        ]);
    }
}
