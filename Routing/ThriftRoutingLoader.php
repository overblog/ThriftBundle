<?php

/*
 * This file is part of the OverblogThriftBundle package.
 *
 * (c) Overblog <http://github.com/overblog/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Overblog\ThriftBundle\Routing;

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class ThriftRoutingLoader extends Loader
{
    protected $services;

    public function __construct($services)
    {
        $this->services = $services;
    }

    /**
     * Loads a resource.
     *
     * @param mixed $resource The resource
     * @param string|null $type The resource type or null if unknown
     *
     * @return RouteCollection
     * @throws \Exception If something went wrong
     */
    public function load($resource, $type = null)
    {
        $controllerArg = Kernel::VERSION_ID > 40000 ?
            'Overblog\ThriftBundle\Controller\ThriftController::serverAction' :
            'ThriftBundle:Thrift:server';

        $coll = new RouteCollection();
        foreach ($this->services as $path => $service) {
            $route = new Route(
                '/'.$path,
                ['_controller' => $controllerArg, 'extensionName' => $path],
                [],
                [],
                null,
                [],
                ['post']
            );
            $coll->add('thrift.'.$service['service'], $route);
        }

        return $coll;
    }

    /**
     * Returns whether this class supports the given resource.
     *
     * @param mixed       $resource A resource
     * @param string|null $type     The resource type or null if unknown
     *
     * @return bool True if this class supports the given resource, false otherwise
     */
    public function supports($resource, $type = null)
    {
        return 'thrift' == $type;
    }
}
