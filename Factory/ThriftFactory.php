<?php

/*
 * This file is part of the OverblogThriftBundle package.
 *
 * (c) Overblog <http://github.com/overblog/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Overblog\ThriftBundle\Factory;

/**
 * Thrift factory.
 *
 * @author Xavier HAUSHERR
 */
class ThriftFactory
{
    protected $services;

    /**
     * Inject dependencies.
     *
     * @param array $services
     */
    public function __construct(array $services)
    {
        $this->services = $services;
    }

    /**
     * Return an instance of a Thrift Model Class.
     *
     * @param string $classe
     * @param mixed  $param
     *
     * @return object
     */
    public function getInstance($classe, $param = null)
    {
        if (is_null($param)) {
            return new $classe();
        } else {
            return new $classe($param);
        }
    }

    /**
     * Return a processor instance.
     *
     * @param string $service
     * @param mixed  $handler
     *
     * @return object
     */
    public function getProcessorInstance($service, $handler)
    {
        $classe = sprintf('%s\%sProcessor', $this->services[$service]['namespace'], $this->services[$service]['className']);

        return new $classe($handler);
    }

    /**
     * Return a client instance.
     *
     * @param string                    $service
     * @param Thrift\Protocol\TProtocol $protocol
     *
     * @return object
     */
    public function getClientInstance($service, $protocol)
    {
        $classe = sprintf('%s\%sClient', $this->services[$service]['namespace'], $this->services[$service]['className']);

        return new $classe($protocol);
    }
}
