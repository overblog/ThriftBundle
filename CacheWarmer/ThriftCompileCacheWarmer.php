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
     * Cache Suffix for thrift compiled files
     */
    const CACHE_SUFFIX = 'thrift';

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
    public function getDefinitionPath($definition, $bundleName = null, $definitionPath = null)
    {
        if(empty($definitionPath) && empty($bundleName))
        {
            throw new \Exception('bundleNameIn or definitionPath must be set');
        }

        if(empty($bundleName))
        {
            $path = $this->container->get('kernel')->getRootDir() . '/../' . $definitionPath . '/';
        }
        else
        {
            $bundle = $this->container->get('kernel')->getBundle($bundleName);
            $bundlePath      = $bundle->getPath();

            $path = $bundlePath . '/ThriftDefinition/';
        }

        return $path . $definition . '.thrift';
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
                $config['definition'],
                $config['bundleNameIn'],
                $config['definitionPath']
            );

            //Set Path
            $compiler->setModelPath(sprintf('%s/%s', $this->cacheDir, self::CACHE_SUFFIX));

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