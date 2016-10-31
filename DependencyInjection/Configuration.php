<?php

/*
 * This file is part of the OverblogThriftBundle package.
 *
 * (c) Overblog <http://github.com/overblog/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Overblog\ThriftBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('overblog_thrift_bundle');

        $rootNode
            ->children()
                ->scalarNode('testMode')->defaultFalse()->end()
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
                            ->scalarNode('className')->defaultNull()->end()
                            ->scalarNode('namespace')->isRequired()->end()
                            ->scalarNode('definitionPath')->isRequired()->end()
                            ->scalarNode('protocol')->defaultValue('Thrift\Protocol\TBinaryProtocolAccelerated')->end()
                            ->scalarNode('transport')->defaultValue('Thrift\Transport\TBufferedTransport')->end()
                            ->scalarNode('buffered_transport')->defaultTrue()->end()
                            ->booleanNode('server')->defaultFalse()->end()
                            ->booleanNode('validate')->defaultFalse()->end()
                            ->arrayNode('includeDirs')
                                ->prototype('scalar')
                                ->end()
                            ->end()
                        ->end()
                        ->validate()
                            ->ifTrue(function ($v) {
                                return empty($v['className']);
                            })
                            ->then(function ($v) {
                                // If className is empty, definition is used
                                $v['className'] = $v['definition'];

                                return $v;
                            })
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('servers')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('service')->isRequired()->end()
                            ->scalarNode('handler')->isRequired()->end()
                            ->booleanNode('fork')->defaultTrue()->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('clients')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('service')->isRequired()->end()
                            ->scalarNode('type')->defaultValue('http')->end()
                            ->integerNode('cache')->defaultValue(0)->end()
                            ->arrayNode('hosts')
                                ->requiresAtLeastOneElement()
                                ->useAttributeAsKey('name')
                                ->prototype('array')
                                    ->children()
                                        ->scalarNode('host')->isRequired()->end()
                                        ->scalarNode('port')->defaultValue(80)->end()
                                        ->scalarNode('recvTimeout')->defaultNull()->end()
                                        ->scalarNode('sendTimeout')->defaultNull()->end()
                                        ->scalarNode('httpTimeoutSecs')->defaultNull()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
            //Server validation
            ->validate()
                ->ifTrue(function ($v) {
                    foreach ($v['servers'] as $name => $server) {
                        if (!isset($v['services'][$server['service']])) {
                            return true;
                        }
                    }

                    return false;
                })
                ->thenInvalid('Unknown service in servers configuration.')
            ->end()
            ->validate()
                ->ifTrue(function ($v) {
                    foreach ($v['clients'] as $name => $client) {
                        if (!isset($v['services'][$client['service']])) {
                            return true;
                        }
                    }

                    return false;
                })
                ->thenInvalid('Unknown service in clients configuration.')
            ->end()
            ->validate()
                ->always()
                ->then(function ($v) {
                    //Servers
                    foreach ($v['servers'] as $name => $server) {
                        $v['servers'][$name]['service_config'] = $v['services'][$server['service']];
                    }

                    //Clients
                    foreach ($v['clients'] as $name => $client) {
                        $v['clients'][$name]['service_config'] = $v['services'][$client['service']];
                    }

                    return $v;
                })
            ->end();

        return $treeBuilder;
    }
}
