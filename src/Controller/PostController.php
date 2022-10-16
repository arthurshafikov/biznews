<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentFormType;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends Controller
{
    #[Route('/posts', name: 'app_posts')]
    public function index(PostRepository $postRepository, Request $request): Response
    {
        $posts = $postRepository->getLatestPosts($this->getPostsPerPageSetting(), $request->get('page', 1));
        $postsCount = $postRepository->getPostsCount();

        return $this->render('post/index.html.twig', [
            'posts' => $posts,
            'pagesCount' => ceil($postsCount / $this->getPostsPerPageSetting()),
        ]);
    }

    #[Route('/search', name: 'app_posts_search')]
    public function search(PostRepository $postRepository, Request $request): Response
    {
        $searchParams = [
            's' => $request->get('s'),
            'date' => $request->get('date'),
        ];
        $posts = $postRepository->getPostsBySearch(
            $searchParams,
            $this->getPostsPerPageSetting(),
            $request->get('page', 1)
        );
        $postsCount = $postRepository->getPostsCount($searchParams);

        return $this->render('post/search.html.twig', [
            'posts' => $posts,
            'pagesCount' => ceil($postsCount / $this->getPostsPerPageSetting()),
        ]);
    }

    #[Route('/posts/{slug}', name: 'app_post')]
    public function show(Post $post, PostRepository $postRepository): Response
    {
        $post->setViews($post->getViews() + 1);
        $postRepository->add($post, true);

        return $this->render('post/single.html.twig', [
            'post' => $post,
            'commentForm' => $this->createForm(CommentFormType::class, ['post' => $post->getId()])->createView(),
            'comments' => $post->getComments()->filter(fn (Comment $comment) => $comment->getParent() === null),
        ]);
    }
}
