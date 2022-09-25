<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    private const POSTS_PER_PAGE = 8;

    #[Route('/category/{slug}', name: 'app_category')]
    public function index(Category $category, PostRepository $postRepository, Request $request): Response
    {
        $postsCount = $postRepository->getPostsCount($category->getId());
        $categoryPosts = $postRepository
            ->getPostsByCategoryID($category->getId(), static::POSTS_PER_PAGE, $request->get('page', 1));

        return $this->render('category/index.html.twig', [
            'category' => $category,
            'posts' => $categoryPosts,
            'pagesCount' => ceil($postsCount / static::POSTS_PER_PAGE),
        ]);
    }
}
