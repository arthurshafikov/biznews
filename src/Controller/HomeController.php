<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(PostRepository $postRepository): Response
    {
        $sliderNews = $postRepository->getPostsByCategoryID(152); // togo get from admin settings
        $nearToSliderNews = $postRepository->getPostsByCategoryID(149); // togo get from admin settings

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'sliderNews' => $sliderNews,
            'nearToSliderNews' => $nearToSliderNews,
        ]);
    }
}
