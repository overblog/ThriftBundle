<?php

/*
 * This file is part of the OverblogThriftBundle package.
 *
 * (c) Overblog <http://github.com/overblog/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Overblog\ThriftBundle\DependencyInjection\Compiler;

use Overblog\ThriftBundle\CacheWarmer\ThriftCompileCacheWarmer;
use Overblog\ThriftBundle\Listener\ClassLoaderListener;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Description of FactoryPass.
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
     * @api
     */
    public function process(ContainerBuilder $container)
    {
        $container->get('thrift.compile_warmer')->compile(true);
    }
}
