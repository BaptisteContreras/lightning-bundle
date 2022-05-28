<?php

namespace Sflightning\Bundle\DependencyInjection\Compiler;

use Sflightning\Bundle\Constante\Tags;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ConcurrencyPromiseBehaviorPass implements CompilerPassInterface {
    /**         Methods         **/

    public function process(ContainerBuilder $container)
    {
       $servicesToProvide = $container->findTaggedServiceIds(Tags::CONCURRENCY_PROMISE_BEHAVIOR);

       foreach ($servicesToProvide as $serviceToProvideId => $tag) {
           $serviceToProvide = $container->findDefinition($serviceToProvideId);
           $serviceToProvide->addMethodCall('setCoroutineConcurrencyManager', [new Reference('lightning.concurrency.promise.manager')]);
       }
    }
}