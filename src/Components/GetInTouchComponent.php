<?php

namespace App\Components;

use App\Entity\Setting;
use App\Repository\SettingRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('get-in-touch')]
class GetInTouchComponent
{
    public function __construct(private readonly SettingRepository $settingRepository)
    {
    }

    public function __call(string $name, array $arguments): ?string
    {
        return $this->settingRepository->getSettingValue(constant(Setting::class . '::' . $name));
    }
}
