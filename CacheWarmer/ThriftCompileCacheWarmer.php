<?php

namespace Overblog\ThriftBundle\CacheWarmer;

use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Overblog\ThriftBundle\Compiler\ThriftCompiler;

class ThriftCompileCacheWarmer implements CacheWarmerInterface
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->config = $this->container->getParameter('thrift.config.compiler');
    }

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

    public function isOptional()
    {
        return false;
    }
}