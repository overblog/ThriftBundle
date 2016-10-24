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
     * @param string $class
     * @param mixed  $param
     *
     * @return object
     */
    public function getInstance($class, $param = null)
    {
        if (is_null($param)) {
            return new $class();
        } else {
            return new $class($param);
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
        $class = $this->getProcessorClassName($service);

        return new $class($handler);
    }

    /**
     * Return a client instance.
     *
     * @param string                     $service
     * @param \Thrift\Protocol\TProtocol $protocol
     *
     * @return object
     */
    public function getClientInstance($service, $protocol)
    {
        $class = $this->getClientClassName($service);

        return new $class($protocol);
    }

    public function getClientClassName($name)
    {
        $service = $this->getService($name);
        $className = sprintf('%s\%sClient', $service['namespace'], $service['className']);

        return $className;
    }

    public function getProcessorClassName($name)
    {
        $service = $this->getService($name);
        $className = sprintf('%s\%sProcessor', $service['namespace'], $service['className']);

        return $className;
    }

    private function getService($name)
    {
        if (!isset($this->services[$name])) {
            throw new \InvalidArgumentException(sprintf('Service "%s" not found.', $name));
        }

        return $this->services[$name];
    }
}
