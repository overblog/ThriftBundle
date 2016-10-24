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

use Thrift\Transport\TSocket;
use Thrift\Transport\TSocketPool;

/**
 * Socket Client.
 *
 * @author Xavier HAUSHERR
 */
class SocketClient extends Client
{
    /**
     * Instanciate Socket Client.
     *
     * @return Thrift\Transport\TSocket
     */
    protected function createSocket()
    {
        $nbHosts = count($this->config['hosts']);

        if ($nbHosts == 1) {
            $host = current($this->config['hosts']);

            $socket = new TSocket($host['host'], $host['port']);
            if (!empty($host['recvTimeout'])) {
                $socket->setRecvTimeout($host['recvTimeout']);
            }
            if (!empty($host['sendTimeout'])) {
                $socket->setSendTimeout($host['sendTimeout']);
            }
        } else {
            $hosts = [];
            $ports = [];

            foreach ($this->config['hosts'] as $host) {
                $hosts[] = $host['host'];
                $ports[] = $host['port'];
            }

            $socket = new TSocketPool($hosts, $ports);
            if (!empty($host['recvTimeout'])) {
                $socket->setRecvTimeout($host['recvTimeout']);
            }
            if (!empty($host['sendTimeout'])) {
                $socket->setSendTimeout($host['sendTimeout']);
            }
        }

        return $socket;
    }
}
