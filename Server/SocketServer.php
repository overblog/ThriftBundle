<?php

namespace Overblog\ThriftBundle\Server;

use Overblog\ThriftBundle\Server\Server;

use Thrift\Server\TServerSocket;
use Thrift\Factory\TTransportFactory;
use Thrift\Factory\TBinaryProtocolFactory;

class SocketServer extends Server
{
    /**
     * Run socket server
     *
     * @param string $host
     * @param int $port
     */
    public function run($host = 'localhost', $port = 9090)
    {
        $transport = new TServerSocket($host, $port);
        $outputTransportFactory = $inputTransportFactory = new TTransportFactory($transport);
        $outputProtocolFactory = $inputProtocolFactory = new TBinaryProtocolFactory();

        // Do we use fork ?
        $fork = 'Thrift\\Server\\' . ($this->config['fork'] ? 'TForkingServer' : 'TSimpleServer');

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