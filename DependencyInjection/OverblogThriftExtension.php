<?php

namespace Overblog\ThriftBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class OverblogThriftExtension extends Extension
{
    /**
     * {@inheritDoc}
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

        //Register clients
        foreach($config['clients']as $client)
        {
            $this->loadClient($client, $container);
        }
    }

    /**
     * Create client service
     * @param array $client
     * @param ContainerBuilder $container
     */
    public function loadClient(Array $client, ContainerBuilder $container)
    {
        $clientDef = new Definition(
            $container->getParameter('thrift.client.class')
        );

        $clientDef->addArgument(new Reference('thrift.factory'));
        $clientDef->addArgument($client);

        $container->setDefinition(
            sprintf('thrift.client.%s', $client['service']),
            $clientDef
        );
    }
}
