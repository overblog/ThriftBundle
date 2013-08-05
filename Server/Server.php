<?php

namespace Overblog\ThriftBundle\Server;

/**
 * Abstract class to create a server
 * @author Xavier HAUSHERR
 */

abstract class Server
{
    /**
     * Thrift Processor
     */
    protected $processor;

    /**
     * Configuration
     * @var array
     */
    protected $config;

    /**
     * Load dependencies
     * @param mixed $processor
     * @param array $config
     */
    public function __construct($processor, Array $config)
    {
        $this->processor = $processor;
        $this->config = $config;
    }

    /**
     * Return thrif header
     */
    public function getHeader()
    {
        header('Content-Type: application/x-thrift');
    }

    /**
     * Run the server
     */
    abstract public function run();
}