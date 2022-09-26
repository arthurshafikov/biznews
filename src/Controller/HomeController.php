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
    private const NUMBER_OF_LATEST_POSTS = 13;

    #[Route('/', name: 'app_home')]
    public function index(PostRepository $postRepository, SettingRepository $settingRepository): Response
    {
        $sliderNews = $postRepository->getPostsByCategoryID(
            $settingRepository->getSettingValue(Setting::SLIDER_POSTS_CATEGORY_ID)
        );
        $nearToSliderNews = $postRepository->getPostsByCategoryID(
            $settingRepository->getSettingValue(Setting::NEAR_TO_SLIDER_POSTS_CATEGORY_ID)
        );
        $breakingNews = $postRepository->getPostsByTagID(
            $settingRepository->getSettingValue(Setting::BREAKING_TAG_ID), 3
        );
        $featuredNews = $postRepository->getPostsByTagID(
            $settingRepository->getSettingValue(Setting::FEATURED_TAG_ID), 8
        );
        $latestNews = $postRepository->getLatestPosts(static::NUMBER_OF_LATEST_POSTS);

        return $this->render('home/index.html.twig', [
            'sliderNews' => $sliderNews,
            'nearToSliderNews' => $nearToSliderNews,
            'breakingNews' => $breakingNews,
            'featuredNews' => $featuredNews,
            'latestNews' => $latestNews,
        ]);
    }
}
