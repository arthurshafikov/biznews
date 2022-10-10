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
        Setting::FACEBOOK_LINK => 'https://facebook.com',
        Setting::TWITTER_LINK => 'https://twitter.com',
        Setting::LINKEDIN_LINK => 'https://linkedin.com',
        Setting::INSTAGRAM_LINK => 'https://instagram.com',
        Setting::YOUTUBE_LINK => 'https://youtube.com',
        Setting::VIMEO_LINK => 'https://vimeo.com',
        Setting::COMPANY_ADDRESS => '123 Street, New York, USA',
        Setting::COMPANY_PHONE => '+012 345 67890',
        Setting::COMPANY_EMAIL => 'info@biznews.com',
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
