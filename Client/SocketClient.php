<?php

namespace Overblog\ThriftBundle\Client;

use Overblog\ThriftBundle\Client\Client;

use Thrift\Transport\TSocket;
use Thrift\Transport\TSocketPool;

/**
 * Socket Client
 * @author Xavier HAUSHERR
 */

class SocketClient extends Client
{
    /**
     * Instanciate Socket Client
     *
     * @return Thrift\Transport\TSocket
     */
    protected function getSocket()
    {
        $nbHosts = count($this->config['hosts']);

        if($nbHosts == 1)
        {
            $host = current($this->config['hosts']);

            $socket = new TSocket($host['host'], $host['port']);
        }
        else
        {
            $hosts = array();
            $ports = array();

            foreach($this->config['hosts'] as $host)
            {
                $hosts[] = $host['host'];
                $ports[] = $host['port'];
            }

            $socket = new TSocketPool($hosts, $ports);
        }

        return $socket;
    }
}