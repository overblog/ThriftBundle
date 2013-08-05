<?php

namespace Overblog\ThriftBundle\Server;

use Overblog\ThriftBundle\Server\Server;

use Thrift\Transport\TBufferedTransport;
use Thrift\Transport\TPhpStream;

/**
 * HTTP Server class
 * @author Xavier HAUSHERR
 */

class HttpServer extends Server
{
    /**
     * Run server
     */
    public function run()
    {
        $transport = new TBufferedTransport(new TPhpStream(TPhpStream::MODE_R | TPhpStream::MODE_W));
        $protocol = new $this->config['protocol']($transport, true, true);

        $transport->open();
        $this->processor->process($protocol, $protocol);
        $transport->close();
    }
}