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

use Thrift\Transport\TBufferedTransport;
use Thrift\Transport\TPhpStream;

/**
 * HTTP Server class.
 *
 * @author Xavier HAUSHERR
 */
class HttpServer extends Server
{
    /**
     * Run server.
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
