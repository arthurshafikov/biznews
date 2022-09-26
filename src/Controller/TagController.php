<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TagController extends AbstractController
{
    private const POSTS_PER_PAGE = 8;

    #[Route('/tag/{slug}', name: 'app_tag')]
    public function index(Tag $tag, PostRepository $postRepository, Request $request): Response
    {
        $tagPosts = $postRepository
            ->getPostsByTagID($tag->getId(), static::POSTS_PER_PAGE, $request->get('page', 1));

        return $this->render('tag/index.html.twig', [
            'tag' => $tag,
            'posts' => $tagPosts,
            'pagesCount' => ceil($tag->getPosts()->count() / static::POSTS_PER_PAGE),
        ]);
    }
}
