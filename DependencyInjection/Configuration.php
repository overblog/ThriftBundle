<?php

namespace Overblog\ThriftBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('overblog_thrift_bundle');

        $rootNode
            ->children()
                ->arrayNode('compiler')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('path')->defaultValue('/usr/local/bin/')->end()
                    ->end()
                ->end()
                ->arrayNode('services')
                    ->requiresAtLeastOneElement()
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('definition')->isRequired()->end()
                            ->scalarNode('namespace')->isRequired()->end()
                            ->scalarNode('bundleNameIn')->isRequired()->end()
                            ->scalarNode('protocol')->defaultValue('Thrift\Protocol\TBinaryProtocolAccelerated')->end()
                            ->booleanNode('server')->defaultValue(false)->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('servers')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('service')->isRequired()->end()
                            ->scalarNode('handler')->isRequired()->end()
                            ->booleanNode('fork')->defaultValue(true)->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('clients')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('service')->isRequired()->end()
                            ->scalarNode('type')->defaultValue('http')->end()
                            ->arrayNode('hosts')
                                ->requiresAtLeastOneElement()
                                ->useAttributeAsKey('name')
                                ->prototype('array')
                                    ->children()
                                        ->scalarNode('host')->isRequired()->end()
                                        ->scalarNode('port')->defaultValue(80)->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
