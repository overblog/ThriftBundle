<?php

/*
 * This file is part of the OverblogThriftBundle package.
 *
 * (c) Overblog <http://github.com/overblog/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Overblog\ThriftBundle\Client;

use Overblog\ThriftBundle\Cache\ClientCacheProxyManager;
use Overblog\ThriftBundle\Factory\ThriftFactory;
use Overblog\ThriftBundle\Metadata\ClientMetadata;
use Overblog\ThriftBundle\Metadata\ServiceMetadata;
use Thrift\Transport\TBufferedTransport;

/**
 * Build client.
 *
 * @author Xavier HAUSHERR
 */
class ThriftClient
{
    /**
     * Thrift factory.
     *
     * @var ThriftFactory
     */
    protected $factory;

    /**
     * Client instance.
     */
    protected $client;

    /**
     * Transport instance.
     */
    protected $transport;

    /**
     * @var ClientMetadata
     */
    protected $metadata;

    /**
     * @var string
     */
    protected $name;

    /**
     * Register Dependencies.
     *
     * @param ThriftFactory $factory
     * @param string        $name
     */
    public function __construct(ThriftFactory $factory, $name)
    {
        $this->factory = $factory;
        $this->name = $name;
        $this->metadata = $factory->getMetadata()->getClient($name);
    }

    /**
     * Return client.
     *
     * @param bool $useCache
     *
     * @return \Thrift\Transport\TSocket
     */
    public function getClient($useCache = true)
    {
        if (is_null($this->client)) {
            $this->client = $this->createClient();
        }

        $this->client->{ClientCacheProxyManager::PROPERTY_USE_CACHE} = $useCache;

        return $this->client;
    }

    /**
     * Instantiate Thrift Model classes.
     *
     * @param string $class
     * @param mixed  $param
     *
     * @return mixed
     */
    public function getFactory($class, $param = null)
    {
        return $this->factory->getInstance($class, $param);
    }

    /**
     * Close every connections.
     */
    public function __destruct()
    {
        if (!is_null($this->transport)) {
            $this->transport->close();
        }
    }

    /**
     * Instantiate client class.
     *
     * @return Client
     */
    protected function clientFactory()
    {
        if ('http-test' === $this->getMetadata()->getType()) {
            $class = 'Overblog\\ThriftBundle\\Tests\\Thrift\\Client\\HttpClient';
        } else {
            $class = sprintf('%s\%sClient', __NAMESPACE__, ucfirst(strtolower($this->getMetadata()->getType())));
        }

        return new $class($this->metadata);
    }

    protected function createClient()
    {
        $serviceMetadata = $this->getServiceMetadata();
        //Initialisation du client
        $this->transport = $this->clientFactory()->getSocket();

        if ($serviceMetadata->isBufferedTransport()) {
            $this->transport = new TBufferedTransport($this->transport);
        }

        $protocol = $serviceMetadata->getProtocol();

        $client = $this->factory->getClientInstance(
            $this->getMetadata()->getService(),
            new $protocol($this->transport)
        );

        $this->transport->open();

        return $client;
    }

    /**
     * @return ClientMetadata
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @return ServiceMetadata
     */
    public function getServiceMetadata()
    {
        return $this->factory->getMetadata()->getService($this->getMetadata()->getService());
    }
}
