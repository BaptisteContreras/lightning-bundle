<?php

namespace Sflightning\Bundle\DependencyInjection;

use Sflightning\Bundle\Concurrency\LightningConcurrencyAware;
use Sflightning\Bundle\Constante\Tags;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class LightningExtension extends Extension
{
    /**         Methods         **/

    public function load(array $configs, ContainerBuilder $container) {
        $loader = new XmlFileLoader($container, new FileLocator(\dirname(__DIR__).'/Resources/config'));
        $loader->load('lightning_services.xml');

        $container->registerForAutoconfiguration(LightningConcurrencyAware::class)
            ->addTag(Tags::CONCURRENCY_PROMISE_BEHAVIOR)
        ;
      //  $configuration = $this->getConfiguration($configs, $container);

      //  $config = $this->processConfiguration($configuration, $configs);
    }
}