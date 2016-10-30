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

use Overblog\ThriftBundle\Thrift\Transport\TPhpStream;
use Thrift\Transport\TBufferedTransport;

/**
 * HTTP Server class.
 *
 * @author Xavier HAUSHERR
 */
class HttpServer extends Server
{
    /**
     * @param null|resource $input
     * @param null|int      $mode
     */
    public function run($input = null, $mode = null)
    {
        $transport = new TBufferedTransport(new TPhpStream(null === $mode ? TPhpStream::MODE_R | TPhpStream::MODE_W : $mode, $input));
        $protocol = new $this->config['protocol']($transport, true, true);

        $transport->open();
        $this->processor->process($protocol, $protocol);
        $transport->close();
    }
}
