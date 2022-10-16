<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentFormType;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use DateTime;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    #[Route('/posts/comment', name: 'app_comment')]
    public function comment(
        Request $request,
        CommentRepository $commentRepository,
        PostRepository $postRepository,
    ): Response {
        $commentForm = $this->createForm(CommentFormType::class);
        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $commentData = $commentForm->getData();
            $comment = new Comment();
            $comment->setPost($postRepository->find($commentData['post']));
            $comment->setUser($this->getUser());
            $comment->setParent($commentData['parent'] ? $commentRepository->find($commentData['parent']) : null);
            $comment->setContent($commentData['content']);
            $comment->setCreatedAt(DateTimeImmutable::createFromMutable(new DateTime()));

            $commentRepository->add($comment, true);

            $request->getSession()->getFlashBag()->add('session-message', [
                'message' => 'Comment added successfully!',
            ]);
        }

        return $this->render('post/comment-form.html.twig', [
            'commentForm' => $commentForm->createView(),
        ]);
    }
}
