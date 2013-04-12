<?php

namespace Overblog\ThriftBundle\Client;

use Overblog\ThriftBundle\Client\Client;

use Thrift\Transport\THttpClient;

/**
 * HTTP Client
 * @author Xavier HAUSHERR
 */

class HttpClient extends Client
{
    /**
     * Instanciate Socket Client
     *
     * @return Thrift\Transport\THttpClient
     */
    protected function createSocket()
    {
        $host = current($this->config['hosts']);

        $url = parse_url($this->config['type'] . '://' . $host['host']);

        $socket = new THttpClient($url['host'], $host['port'], $url['path']);

        if (!empty($host['httpTimeoutSecs']))
        {
            $socket->setTimeoutSecs($host['httpTimeoutSecs']);
        }

        return $socket;
    }
}