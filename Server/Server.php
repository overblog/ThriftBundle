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
     * Configuration.
     *
     * @var array
     */
    protected $config;

    /**
     * Load dependencies.
     *
     * @param mixed $processor
     * @param array $config
     */
    public function __construct($processor, array $config)
    {
        $this->processor = $processor;
        $this->config = $config;
    }

    /**
     * Run the server.
     */
    abstract public function run();
}
