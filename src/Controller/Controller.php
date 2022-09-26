<?php

namespace App\Controller;

use App\Entity\Setting;
use App\Repository\SettingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class Controller extends AbstractController
{
    public function __construct(protected readonly SettingRepository $settingRepository)
    {
    }

    protected function getPostsPerPageSetting(): int
    {
        return (int) $this->settingRepository->getSettingValue(Setting::POSTS_PER_PAGE);
    }
}
