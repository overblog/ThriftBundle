<?php

namespace Overblog\ThriftBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Overblog\ThriftBundle\DependencyInjection\Compiler\FactoryPass;

/**
 * Overblog Thrift Bundle
 * @author Xavier HAUSHERR
 */

class OverblogThriftBundle extends Bundle
{
    /**
     * Builds the bundle.
     *
     * It is only ever called once when the cache is empty.
     *
     * This method can be overridden to register compilation passes,
     * other extensions, ...
     *
     * @param ContainerBuilder $container A ContainerBuilder instance
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new FactoryPass());
    }
}
