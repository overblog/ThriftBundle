<?php

namespace Overblog\ThriftBundle\Client;

/**
 * Abstract class for create a client
 * @author Xavier HAUSHERR
 */

abstract class Client
{
    /**
     * Config handler
     * @var array
     */
    protected $config;

    /**
     * Socket instance
     * @var Thrift\Transport\TSocket
     */
    protected $socket;

    /**
     * Register dependencies
     * @param array $config
     */
    public function __construct(Array $config)
    {
        $this->config = $config;
    }

    /**
     * Return socket
     *
     * @return Thrift\Transport\TSocket
     */
    public function getSocket()
    {
        if(is_null($this->socket))
        {
            $this->socket = $this->createSocket();
        }

        return $this->socket;
    }

    /**
     * Insctanciate socket
     *
     * @return Thrift\Transport\TSocket
     */
    abstract protected function createSocket();
}