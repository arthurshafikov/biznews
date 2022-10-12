<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class TokenGeneratorService
{
    public function __construct(private readonly ParameterBagInterface $parameterBag)
    {
    }

    public function generateToken(string $email): string
    {
        return sha1($email . $this->parameterBag->get('app.secret'));
    }
}
