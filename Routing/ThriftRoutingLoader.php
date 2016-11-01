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

use Overblog\ThriftBundle\Metadata\Metadata;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class ThriftRoutingLoader extends Loader
{
    protected $metadata;

    public function __construct(Metadata $metadata)
    {
        $this->metadata = $metadata;
    }

    /**
     * Loads a resource.
     *
     * @param mixed       $resource The resource
     * @param string|null $type     The resource type or null if unknown
     *
     * @return RouteCollection
     *
     * @throws \Exception If something went wrong
     */
    public function load($resource, $type = null)
    {
        $coll = new RouteCollection();
        foreach ($this->metadata->getServers() as $name => $serverMetadata) {
            $route = new Route(
                '/'.$name,
                ['_controller' => 'OverblogThriftBundle:Thrift:server', 'extensionName' => $name],
                [],
                [],
                null,
                [],
                ['post']
            );
            $coll->add('thrift.'.$serverMetadata->getService(), $route);
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
