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
    private $cacheDir;
    private $path;
    private $services;

    /**
     * Register dependencies
     * @param ContainerInterface $container
     * @param Array $config
     * @param Array $services
     */
    public function __construct(ContainerInterface $container, $path, Array $services)
    {
        $this->container = $container;
        $this->cacheDir = $this->container->get('kernel')->getCacheDir();
        $this->path = $path;
        $this->services = $services;
    }

    /**
     * Return definition path
     * @param string $bundleName
     * @param string $definition
     * @return string
     */
    public function getDefinitionPath($bundleName, $definition)
    {
        $bundle = $this->container->get('kernel')->getBundle($bundleName);
        $bundlePath      = $bundle->getPath();

        return $bundlePath . '/ThriftDefinition/' . $definition . '.thrift';
    }

    /**
     * Generate model
     * @param string $cacheDir
     */
    public function warmUp($cacheDir)
    {
        $compiler = new ThriftCompiler();
        $compiler->setExecPath($this->path);

        // We compile for every Service
        foreach($this->services as $config)
        {
            $definitionPath  = $this->getDefinitionPath(
                $config['bundleNameIn'],
                $config['definition']
            );

            //Set Path
            $compiler->setModelPath(sprintf('%s/ThriftModel', $this->cacheDir));

            // Empty old model
            $compiler->emptyModelPath($config['definition']);

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