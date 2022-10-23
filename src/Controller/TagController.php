<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TagController extends Controller
{
    #[Route('/tag/{slug}', name: 'app_tag', requirements: ['slug' => '[a-z-]+'])]
    public function index(Tag $tag, PostRepository $postRepository, Request $request): Response
    {
        $tagPosts = $postRepository
            ->getPostsByTagID($tag->getId(), $this->getPostsPerPageSetting(), $request->get('page', 1));

        return $this->render('tag/index.html.twig', [
            'tag' => $tag,
            'posts' => $tagPosts,
            'pagesCount' => ceil($tag->getPosts()->count() / $this->getPostsPerPageSetting()),
        ]);
    }
}
