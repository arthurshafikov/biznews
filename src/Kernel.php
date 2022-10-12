<?php

namespace App;

use App\Events\SubscribedEmailCreated;
use App\Events\UserChangedEmail;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\EventDispatcher\DependencyInjection\AddEventAliasesPass;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new AddEventAliasesPass([
            SubscribedEmailCreated::class => SubscribedEmailCreated::NAME,
            UserChangedEmail::class => UserChangedEmail::NAME,
        ]));
    }
}
