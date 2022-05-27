<?php


namespace Sflightning\Bundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    /**         Properties         **/
    /**         Constructor         **/
    /**         Methods         **/
    /**         Accessors         **/

    public function getConfigTreeBuilder(): TreeBuilder
    {
        return new TreeBuilder('lightning');
    }
}