<?php

namespace App\Service;

use App\Entity\Comment;
use App\Entity\User;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use DateTime;
use DateTimeImmutable;

class CommentService
{
    public function __construct(
        private readonly CommentRepository $commentRepository,
        private readonly PostRepository $postRepository,
    ) {
    }

    public function add(array $params, User $user): void
    {
        $comment = new Comment();
        $comment->setPost($this->postRepository->find($params['post']));
        $comment->setUser($user);
        $comment->setParent($params['parent'] ? $this->commentRepository->find($params['parent']) : null);
        $comment->setContent($params['content']);
        $comment->setCreatedAt(DateTimeImmutable::createFromMutable(new DateTime()));

        $this->commentRepository->add($comment, true);
    }
}
