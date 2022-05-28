<?php

namespace Sflightning\Bundle;

use Sflightning\Bundle\DependencyInjection\Compiler\ConcurrencyPromiseBehaviorPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class LightningBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ConcurrencyPromiseBehaviorPass());
    }

}