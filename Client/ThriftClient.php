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
     * @return Thrift\Transport\TSocket
     */
    public function getClient()
    {
        if (is_null($this->client)) {
            $service = $this->config['service_config'];
            //Initialisation du client
            $socket = $this->clientFactory()->getSocket();

            if (isset($service['transport'])) {
                $this->transport = new $service['transport']($socket);
            } else {
                $this->transport = new TBufferedTransport($socket, 1024, 1024);
            }

            $this->client = $this->factory->getClientInstance(
                $this->config['service'],
                new $service['protocol']($this->transport)
            );

            $this->transport->open();
        }

        return $this->client;
    }

    /**
     * Instanciate Thrift Model classes.
     *
     * @param string $classe
     * @param mixed  $param
     *
     * @return mixed
     */
    public function getFactory($classe, $param = null)
    {
        return $this->factory->getInstance($classe, $param);
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
     * Instanciate client class.
     *
     * @param string $name
     *
     * @return Client
     */
    protected function clientFactory()
    {
        $class = sprintf('%s\%sClient', __NAMESPACE__, ucfirst(strtolower($this->config['type'])));

        return new $class($this->config);
    }
}
