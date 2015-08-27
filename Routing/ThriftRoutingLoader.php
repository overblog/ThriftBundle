<?php

namespace Overblog\ThriftBundle\Routing;

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
     * @throws \Exception If something went wrong
     */
    public function load($resource, $type = null)
    {
        $coll = new RouteCollection();
        foreach ($this->services as $path => $service) {
            $route = new Route(
                '/'.$path,
                array('_controller' => 'ThriftBundle:Thrift:server'),
                array(),
                array(),
                null,
                array(),
                array('post')
            );
            $coll->add('thrift.' . $service['service'], $route);
        }
        return $coll;
    }

    /**
     * Returns whether this class supports the given resource.
     *
     * @param mixed $resource A resource
     * @param string|null $type The resource type or null if unknown
     *
     * @return bool True if this class supports the given resource, false otherwise
     */
    public function supports($resource, $type = null)
    {
        return 'thrift' == $type;
    }
}
