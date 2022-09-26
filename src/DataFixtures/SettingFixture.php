<?php

namespace App\DataFixtures;

use App\Entity\Setting;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SettingFixture extends Fixture implements DependentFixtureInterface
{
    private const SETTINGS = [
        Setting::SLIDER_POSTS_CATEGORY_ID => 'category_1',
        Setting::NEAR_TO_SLIDER_POSTS_CATEGORY_ID => 'category_2',
        Setting::FEATURED_TAG_ID => 'tag_1',
        Setting::BREAKING_TAG_ID => 'tag_0',
        Setting::POSTS_PER_PAGE => 8,
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (static::SETTINGS as $settingName => $value) {
            $setting = new Setting();

            $value = strpos($value, '_')
                ? $this->getReference($value)->getId()
                : $value;

            $setting->setName($settingName)->setValue($value);
            $manager->persist($setting);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            TagFixture::class,
        ];
    }
}
