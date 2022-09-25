<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    private const POSTS_PER_PAGE = 8;

    #[Route('/posts', name: 'app_posts')]
    public function index(PostRepository $postRepository, Request $request): Response
    {
        $posts = $postRepository->getLatestPosts(static::POSTS_PER_PAGE, $request->get('page', 1));
        $postsCount = $postRepository->getPostsCount();

        return $this->render('post/index.html.twig', [
            'posts' => $posts,
            'pagesCount' => ceil($postsCount / static::POSTS_PER_PAGE),
        ]);
    }

    #[Route('/posts/{post}', name: 'app_post')]
    public function show(Post $post): Response
    {
        return $this->render('post/single.html.twig', [
            'post' => $post,
        ]);
    }
}
