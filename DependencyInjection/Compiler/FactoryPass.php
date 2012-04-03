<?php

namespace Overblog\ThriftBundle\DependencyInjection\Compiler;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

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
        foreach ($container->findTaggedServiceIds('thrift.extension') as $id => $attributes)
        {
            $ext = $container->getDefinition($id);
            $ext->setFactoryService('thrift.factory');
            $ext->setFactoryMethod('initExtensionInstance');

            // Add className as the first argument
            $ext->setArguments(array(
                $ext->getClass(),
                $ext->getArguments()
            ));
        }
    }
}

