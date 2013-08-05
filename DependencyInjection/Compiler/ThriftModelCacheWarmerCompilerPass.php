<?php

namespace Overblog\ThriftBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ThriftModelCacheWarmerCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        echo 'OK';
    }
}