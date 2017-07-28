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

use Overblog\ThriftBundle\Cache\ClientCacheProxyManager;
use Overblog\ThriftBundle\Client\ThriftClient;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class OverblogThriftExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('thrift.config.compiler.path', $config['compiler']['path']);
        $container->setParameter('thrift.config.services', $config['services']);
        $container->setParameter('thrift.config.servers', $config['servers']);
        
        $this->loadMetadata($config, $container);
        $this->loadClients($config, $container);
        $this->loadClientsCacheProxy($config, $container);
    }

    /**
     * Create clients service.
     *
     * @param array            $config
     * @param ContainerBuilder $container
     */
    private function loadClients(array $config, ContainerBuilder $container)
    {
        // Register clients
        foreach ($config['clients'] as $name => $clientConfig) {
            $clientDef = new DefinitionDecorator($config['testMode'] ? 'thrift.client.test' : 'thrift.client');
            $clientDef->replaceArgument(1, $name);
            $clientDef->setPublic(true);
            $container->setDefinition(ThriftClient::getServiceClientID($name), $clientDef);
        }
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     */
    private function loadMetadata(array $config, ContainerBuilder $container)
    {
        $metaDataDefinition = $container->getDefinition('thrift.metadata');
        $metaDataDefinition->replaceArgument(0, [
            'services' => $config['services'],
            'clients' => $config['clients'],
            'servers' => $config['servers'],
            'compiler' => $config['compiler'],
        ]);
    }

    private function loadClientsCacheProxy(array $config, ContainerBuilder $container)
    {
        if (!ClientCacheProxyManager::isRequirementsFulfilled()) {
            return;
        }
        $cacheAdapterID = $config['definitions']['cache_adapter'];

        if (null === $cacheAdapterID) {
            $cacheAdapterID = 'thrift.default_cache_adapter';
            $definition = new Definition(
                'Symfony\\Component\\Cache\\Adapter\\FilesystemAdapter',
                ['thrift', 0, $container->getParameter('thrift.cache_dir').'/cache']
            );
            $definition->setPublic(false);
            $container->setDefinition('thrift.default_cache_adapter', $definition);
        }

        $container->setAlias('thrift.cache_adapter', $cacheAdapterID);

        $managerDefinition = $container->getDefinition('thrift.client_cache_proxy_manager');
        $managerDefinition->replaceArgument(1, new Reference('thrift.cache_adapter'));
    }
}
