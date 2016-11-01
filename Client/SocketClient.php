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
     * {@inheritdoc}
     */
    protected function createSocket()
    {
        $nbHosts = count($this->metadata->getHosts());

        if ($nbHosts == 1) {
            /**
             * @var HostMetadata
             */
            $hostMetadata = current($this->metadata->getHosts());

            $socket = new TSocket($hostMetadata->getHost(), $hostMetadata->getPort());
            if ($hostMetadata->getRecvTimeout()) {
                $socket->setRecvTimeout($hostMetadata->getRecvTimeout());
            }
            if ($hostMetadata->getSendTimeout()) {
                $socket->setSendTimeout($hostMetadata->getSendTimeout());
            }
        } else {
            $hosts = [];
            $ports = [];
            $recvTimeout = null;
            $sendTimeout = null;

            foreach ($this->metadata->getHosts() as $hostMetadata) {
                $hosts[] = $hostMetadata->getHost();
                $ports[] = $hostMetadata->getPort();

                $recvTimeout = null === $recvTimeout || $hostMetadata->getRecvTimeout() < $recvTimeout ? $hostMetadata->getRecvTimeout() : $recvTimeout;
                $sendTimeout = null === $sendTimeout || $hostMetadata->getSendTimeout() < $sendTimeout ? $hostMetadata->getSendTimeout() : $sendTimeout;
            }

            $socket = new TSocketPool($hosts, $ports);
            if ($recvTimeout) {
                $socket->setRecvTimeout($recvTimeout);
            }
            if ($sendTimeout) {
                $socket->setSendTimeout($sendTimeout);
            }
        }

        return $socket;
    }
}
