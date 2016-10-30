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
        $host = current($this->config['hosts']);
        $url = parse_url($this->config['type'].'://'.$host['host']);
        $class = $this->getSocketClassName();

        /** @var THttpClient $socket */
        $socket = new $class($url['host'], $host['port'], $url['path']);

        if (!empty($host['httpTimeoutSecs'])) {
            $socket->setTimeoutSecs($host['httpTimeoutSecs']);
        }

        return $socket;
    }

    protected function getSocketClassName()
    {
        return '\\Thrift\\Transport\\THttpClient';
    }
}
