<?php

namespace App\Controller;

use App\Entity\Setting;
use App\Repository\PostRepository;
use App\Repository\SettingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(PostRepository $postRepository, SettingRepository $settingRepository): Response
    {
        $sliderNews = $postRepository->getPostsByCategoryID(
            $settingRepository->getSettingValue(Setting::SLIDER_POSTS_CATEGORY_ID)
        );
        $nearToSliderNews = $postRepository->getPostsByCategoryID(
            $settingRepository->getSettingValue(Setting::NEAR_TO_SLIDER_POSTS_CATEGORY_ID)
        );
        $featuredNews = $postRepository->getPostsByCategoryID(
            $settingRepository->getSettingValue(Setting::FEATURED_NEWS_CATEGORY_ID), 8
        );
        $breakingNews = $postRepository->getPostsWhereTagIsBreaking();

        return $this->render('home/index.html.twig', [
            'sliderNews' => $sliderNews,
            'nearToSliderNews' => $nearToSliderNews,
            'breakingNews' => $breakingNews,
            'featuredNews' => $featuredNews,
        ]);
    }
}
