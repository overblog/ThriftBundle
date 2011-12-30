<?php

namespace Overblog\ThriftBundle\Config;

/**
 * ConfigCache manages Thrift PHP cache files.
 *
 * When debug is enabled, it knows when to flush the cache
 * thanks to an array of ResourceInterface instances.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class ConfigCache
{
    private $warmer;
    private $file;
    private $debug;

    /**
     * Constructor.
     *
     * @param string  $file     The absolute cache path
     * @param Boolean $debug    Whether debugging is enabled or not
     */
    public function __construct($file, $debug)
    {
        $this->file = $file;
        $this->debug = (Boolean) $debug;
    }

    /**
     * Gets the cache file path.
     *
     * @return string The cache file path
     */
    public function __toString()
    {
        return $this->file;
    }
}