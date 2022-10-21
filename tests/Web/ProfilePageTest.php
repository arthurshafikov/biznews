<?php

namespace App\Tests\Web;

use App\EntityFactory\UserFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProfilePageTest extends WebTestCase
{
    public function testUpdateProfilePage(): void
    {
        $client = static::createClient();
        $user = $client->getContainer()->get(UserFactory::class)->createFake();
        $client->loginUser($user);
        $client->followRedirects();
        $profileUrl = $client->getContainer()->get('router')->generate('app_profile');
        $client->request('GET', $profileUrl);

        $client->submitForm('Submit', [
            'profile_form[name]' => 'New Name',
            'profile_form[email]' => 'new@email.com',
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('p', 'You have successfully changed profile info!');
        $this->assertInputValueSame('profile_form[name]', 'New Name');
        $this->assertInputValueSame('profile_form[email]', 'new@email.com');
        $this->assertSelectorTextContains('div.invalid-feedback.d-block', 'Please verify your email');
    }
}
