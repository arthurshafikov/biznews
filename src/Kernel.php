<?php

namespace App;

use App\Events\SubscribedEmailCreated;
use App\Events\UserRegistered;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\EventDispatcher\DependencyInjection\AddEventAliasesPass;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new AddEventAliasesPass([
            SubscribedEmailCreated::class => SubscribedEmailCreated::NAME,
            UserRegistered::class => UserRegistered::NAME,
        ]));
    }
}
