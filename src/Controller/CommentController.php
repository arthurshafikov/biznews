<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Repository\CommentRepository;
use DateTime;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    #[Route('/posts/{slug}/comment', name: 'app_comment')]
    public function comment(Post $post, Request $request, CommentRepository $commentRepository): Response
    {
        $comment = new Comment();
        $comment->setPost($post);
        $comment->setUser($this->getUser());
        $comment->setParent($commentRepository->find($request->get('parent_id')));
        $comment->setContent($request->get('content'));
        $comment->setCreatedAt(DateTimeImmutable::createFromMutable(new DateTime()));

        $commentRepository->add($comment, true);

        $request->getSession()->getFlashBag()->add('session-message',  [
            'message' => 'Comment added successfully!',
        ]);

        return $this->redirectToRoute('app_post', [
            'slug' => $post->getSlug(),
        ]);
    }
}
