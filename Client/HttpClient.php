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

use Overblog\ThriftBundle\Metadata\HostMetadata;
use Thrift\Transport\THttpClient;

/**
 * HTTP Client.
 *
 * @author Xavier HAUSHERR
 */
class HttpClient extends Client
{
    /**
     * {@inheritdoc}
     */
    protected function createSocket()
    {
        /**
         * @var HostMetadata
         */
        $host = current($this->metadata->getHosts());
        $url = parse_url($this->metadata->getType().'://'.$host->getHost());
        $class = $this->getSocketClassName();

        /** @var THttpClient $socket */
        $socket = new $class($url['host'], $host->getPort(), $url['path']);

        if ($host->getHttpTimeoutSecs()) {
            $socket->setTimeoutSecs($host->getHttpTimeoutSecs());
        }

        return $socket;
    }

    protected function getSocketClassName()
    {
        return '\\Thrift\\Transport\\THttpClient';
    }
}
