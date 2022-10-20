<?php

namespace App\Tests\Unit\Service;

use App\Service\TokenGeneratorService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TokenGeneratorServiceTest extends KernelTestCase
{
    public function testGenerateToken()
    {
        $container = static::getContainer();
        $email = 'some@email.com';
        $expectedToken = '6dfb5d90f9041dc943a53b764a41b45b3c947057';
        /** @var TokenGeneratorService $tokenGeneratorService */
        $tokenGeneratorService = $container->get(TokenGeneratorService::class);

        $token = $tokenGeneratorService->generateToken($email);

        $this->assertSame($expectedToken, $token);
    }
}
