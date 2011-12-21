<?php

namespace Overblog\ThriftBundle\CacheWarmer;

use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Overblog\ThriftBundle\Compiler\ThriftCompiler;

/**
 * Generate Thrift model in cache warmer
 * @author Xavier HAUSHERR
 */

class ThriftCompileCacheWarmer implements CacheWarmerInterface
{
    private $container;

    /**
     * Register dependencies
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->config = $this->container->getParameter('thrift.config.compiler');
    }

    /**
     * Generate model
     * @param string $cacheDir
     */
    public function warmUp($cacheDir)
    {
        $compiler = new ThriftCompiler();

        // We compile for every Service
        foreach($this->config as $definition => $config)
        {
            $bundleName      = $config['bundleNameIn'];
            $bundle          = $this->container->get('kernel')->getBundle($bundleName);
            $bundlePath      = $bundle->getPath();

            $definitionPath  = $bundlePath . '/ThriftDefinition/' . $definition . '.thrift';

            $bundleName      = (!empty($config['bundleNameOut'])) ? $config['bundleNameOut'] : $bundleName;
            $bundle          = $this->container->get('kernel')->getBundle($bundleName);
            $bundlePath      = $bundle->getPath();

            //Set Path
            $compiler->setModelPath(sprintf('%s/ThriftModel', $bundlePath));

            // Empty old model
            $compiler->emptyModelPath($definition);

            //Add namespace prefix
            $compiler->setNamespacePrefix($bundle->getNamespace());

            $compiler->compile($definitionPath, $config['server']);
        }
    }

    /**
     * This warm is not an option
     * @return boolean
     */
    public function isOptional()
    {
        return false;
    }
}