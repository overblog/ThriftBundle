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

use Overblog\ThriftBundle\Factory\ThriftFactory;
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
     * Client config.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Client instance.
     */
    protected $client;

    /**
     * Transport instance.
     */
    protected $transport;

    /**
     * Register Dependencies.
     *
     * @param \Overblog\ThriftBundle\Factory\ThriftFactory $factory
     * @param array                                        $config
     */
    public function __construct(ThriftFactory $factory, array $config)
    {
        $this->factory = $factory;
        $this->config = $config;
    }

    /**
     * Return client.
     *
     * @return \Thrift\Transport\TSocket
     */
    public function getClient()
    {
        if (is_null($this->client)) {
            $this->client = $this->createClient();
        }

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
        if ('http-test' === $this->config['type']) {
            $class = '\\Overblog\\ThriftBundle\\Tests\\Thrift\\Client\\HttpClient';
        } else {
            $class = sprintf('%s\%sClient', __NAMESPACE__, ucfirst(strtolower($this->config['type'])));
        }

        return new $class($this->config);
    }

    protected function createClient()
    {
        $service = $this->config['service_config'];
        //Initialisation du client
        $this->transport = $this->clientFactory()->getSocket();

        if (isset($service['buffered_transport']) && true === $service['buffered_transport']) {
            $this->transport = new TBufferedTransport($this->transport);
        }

        $client = $this->factory->getClientInstance(
            $this->config['service'],
            new $service['protocol']($this->transport)
        );

        $this->transport->open();

        return $client;
    }
}
