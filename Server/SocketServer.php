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
use Thrift\Server\TServerSocket;

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
     */
    public function run($host = 'localhost', $port = 9090)
    {
        $transport = new TServerSocket($host, $port);
        $outputTransportFactory = $inputTransportFactory = new TTransportFactory($transport);
        $outputProtocolFactory = $inputProtocolFactory = new TBinaryProtocolFactory();

        // Do we use fork ?
        $fork = 'Thrift\\Server\\'.($this->config['fork'] ? 'TForkingServer' : 'TSimpleServer');

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
