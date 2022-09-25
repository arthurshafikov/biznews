<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    #[Route('/post/{post}', name: 'app_post')]
    public function show(Post $post): Response
    {
        return $this->render('post/single.html.twig', [
            'post' => $post,
        ]);
    }
}
