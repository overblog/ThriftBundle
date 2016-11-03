<?php

/*
 * This file is part of the OverblogThriftBundle package.
 *
 * (c) Overblog <http://github.com/overblog/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Overblog\ThriftBundle\Server;

use Thrift\Factory\TBinaryProtocolFactory;
use Thrift\Factory\TTransportFactory;
use Thrift\Server\TForkingServer;
use Thrift\Server\TServerSocket;
use Thrift\Server\TSimpleServer;

/**
 * Socket Server class.
 *
 * @author Xavier HAUSHERR
 */
class SocketServer extends Server
{
    /**
     * Run socket server.
     *
     * @param string $host
     * @param int    $port
     * @param bool   $isForked
     */
    public function run($host = 'localhost', $port = 9090, $isForked = true)
    {
        $transport = new TServerSocket($host, $port);
        $outputTransportFactory = $inputTransportFactory = new TTransportFactory($transport);
        $outputProtocolFactory = $inputProtocolFactory = new TBinaryProtocolFactory();

        // Do we use fork ?
        $fork = 'Thrift\\Server\\'.($isForked ? 'TForkingServer' : 'TSimpleServer');

        /**
         * @var TForkingServer|TSimpleServer
         */
        $server = new $fork(
            $this->processor,
            $transport,
            $inputTransportFactory,
            $outputTransportFactory,
            $inputProtocolFactory,
            $outputProtocolFactory
        );

        $server->serve();
    }
}
