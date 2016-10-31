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
use Overblog\ThriftBundle\Cache\ClientCacheProxyManager;

/**
 * Thrift factory.
 *
 * @author Xavier HAUSHERR
 */
class ThriftFactory
{
    private $services;

    /**
     * @var ClientCacheProxyManager
     */
    private $clientCacheProxyManager;

    /**
     * Inject dependencies.
     *
     * @param array $services
     * @param ClientCacheProxyManager $clientCacheProxyManager
     */
    public function __construct(array $services, ClientCacheProxyManager $clientCacheProxyManager)
    {
        $this->services = $services;
        $this->clientCacheProxyManager = $clientCacheProxyManager;
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
        $client = new $class($protocol);
        $ttl = isset($this->services[$service]['cache']) ? $this->services[$service]['cache'] : 0;
        if ($ttl > 0 && !class_exists('ProxyManager\\Factory\\AccessInterceptorValueHolderFactory')) {
            throw new \RuntimeException('To use thrift client cache, the package "ocramius/proxy-manager" is required');
        }
        $clientCacheProxy = $this->clientCacheProxyManager->getClientCacheProxy($client, $ttl);

        return $clientCacheProxy;
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
