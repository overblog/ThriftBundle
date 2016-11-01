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
use Overblog\ThriftBundle\Metadata\Metadata;

/**
 * Thrift factory.
 *
 * @author Xavier HAUSHERR
 */
class ThriftFactory
{
    /**
     * @var Metadata
     */
    private $metadata;

    /**
     * @var ClientCacheProxyManager
     */
    private $clientCacheProxyManager;

    /**
     * Inject dependencies.
     *
     * @param Metadata                $metadata
     * @param ClientCacheProxyManager $clientCacheProxyManager
     */
    public function __construct(Metadata $metadata, ClientCacheProxyManager $clientCacheProxyManager = null)
    {
        $this->metadata = $metadata;
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
        if (null === $this->clientCacheProxyManager) {
            return $client;
        }

        $ttl = $this->getMetadata()->getClient($service)->getCache();
        if ($ttl > 0 && !class_exists('ProxyManager\\Factory\\AccessInterceptorValueHolderFactory')) {
            throw new \RuntimeException('To use thrift client cache, the package "ocramius/proxy-manager" is required');
        }
        $clientCacheProxy = $this->clientCacheProxyManager->getClientCacheProxy($client, $ttl);

        return $clientCacheProxy;
    }

    public function getClientClassName($name)
    {
        $service = $this->getMetadata()->getService($name);
        $className = sprintf('%s\%sClient', $service->getNamespace(), $service->getClassName());

        return $className;
    }

    public function getProcessorClassName($name)
    {
        $service = $this->getMetadata()->getService($name);
        $className = sprintf('%s\%sProcessor', $service->getNamespace(), $service->getClassName());

        return $className;
    }

    /**
     * @return Metadata
     */
    public function getMetadata()
    {
        return $this->metadata;
    }
}
