<?php
/**
 * UNIT TEST
 *
 * @author Xavier HAUSHERR
 */
namespace Overblog\ThriftBundle\Tests\Command;

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernelMock extends Kernel
{
    public function registerBundles()
    {

    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {

    }
}