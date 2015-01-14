<?php

namespace Overblog\ThriftBundle\DependencyInjection\Compiler;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Overblog\ThriftBundle\CacheWarmer\ThriftCompileCacheWarmer;
use Overblog\ThriftBundle\Listener\ClassLoaderListener;

/**
 * Description of FactoryPass
 *
 * @author xavier
 */
class FactoryPass implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @return void
     *
     * @api
     */
    function process(ContainerBuilder $container)
    {
        $cacheDir = $container->getParameter('kernel.cache_dir');

        $warmer = new ThriftCompileCacheWarmer(
                    $cacheDir,
                    $container->getParameter('kernel.root_dir'),
                    $container->getParameter('thrift.config.compiler.path'),
                    $container->getParameter('thrift.config.services')
                );

        $warmer->compile();

        // Init Class Loader
        ClassLoaderListener::registerClassLoader($cacheDir);
    }
}

