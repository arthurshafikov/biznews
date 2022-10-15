<?php

namespace App\Entity;

use App\Repository\SettingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SettingRepository::class)]
class Setting
{
    public const SLIDER_POSTS_CATEGORY_ID = 'slider_posts_category_id';
    public const NEAR_TO_SLIDER_POSTS_CATEGORY_ID = 'near_to_slider_posts_category_id';
    public const FEATURED_TAG_ID = 'featured_tag_id';
    public const BREAKING_TAG_ID = 'breaking_tag_id';
    public const POSTS_PER_PAGE = 'posts_per_page';
    public const FACEBOOK_LINK = 'facebook_link';
    public const TWITTER_LINK = 'twitter_link';
    public const LINKEDIN_LINK = 'linkedin_link';
    public const INSTAGRAM_LINK = 'instagram_link';
    public const YOUTUBE_LINK = 'youtube_link';
    public const VIMEO_LINK = 'vimeo_link';
    public const COMPANY_ADDRESS = 'company_address';
    public const COMPANY_PHONE = 'company_phone';
    public const COMPANY_EMAIL = 'company_email';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, unique: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $value = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }
}
