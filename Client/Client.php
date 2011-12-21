<?php

namespace Overblog\ThriftBundle\Client;

abstract class Client
{
    protected $config;
    protected $socket;

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