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

use Overblog\ThriftBundle\Metadata\ClientMetadata;

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
     * @var ClientMetadata
     */
    protected $metadata;

    /**
     * Socket instance.
     *
     * @var \Thrift\Transport\TSocket
     */
    protected $socket;

    /**
     * Register dependencies.
     *
     * @param ClientMetadata $metadata
     */
    public function __construct(ClientMetadata $metadata)
    {
        $this->metadata = $metadata;
    }

    /**
     * Return socket.
     *
     * @return \Thrift\Transport\TSocket
     */
    public function getSocket()
    {
        if (is_null($this->socket)) {
            $this->socket = $this->createSocket();
        }

        return $this->socket;
    }

    /**
     * Instantiate socket.
     *
     * @return \Thrift\Transport\TSocket
     */
    abstract protected function createSocket();
}
