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

/**
 * Abstract class for create a client.
 *
 * @author Xavier HAUSHERR
 */
abstract class Client
{
    /**
     * Config handler.
     *
     * @var array
     */
    protected $config;

    /**
     * Socket instance.
     *
     * @var Thrift\Transport\TSocket
     */
    protected $socket;

    /**
     * Register dependencies.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Return socket.
     *
     * @return Thrift\Transport\TSocket
     */
    public function getSocket()
    {
        if (is_null($this->socket)) {
            $this->socket = $this->createSocket();
        }

        return $this->socket;
    }

    /**
     * Insctanciate socket.
     *
     * @return Thrift\Transport\TSocket
     */
    abstract protected function createSocket();
}
