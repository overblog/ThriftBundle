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

/**
 * Abstract class to create a server.
 *
 * @author Xavier HAUSHERR
 */
abstract class Server
{
    /**
     * Thrift Processor.
     */
    protected $processor;

    /**
     * Load dependencies.
     *
     * @param mixed $processor
     */
    public function __construct($processor)
    {
        $this->processor = $processor;
    }
}
