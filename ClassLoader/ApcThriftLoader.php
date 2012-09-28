<?php

namespace Overblog\ThriftBundle\ClassLoader;

use Overblog\ThriftBundle\ClassLoader\ThriftLoader;

/**
 * Description of ApcThriftLoader
 *
 * @author xavier
 */
class ApcThriftLoader extends ThriftLoader
{
    private $prefix;

    /**
     * Constructor.
     *
     * @param string $prefix A prefix to create a namespace in APC
     *
     * @throws \RuntimeException
     * @api
     */
    public function __construct($prefix)
    {
        if (!extension_loaded('apc')) {
            throw new \RuntimeException('Unable to use ApcUniversalClassLoader as APC is not enabled.');
        }

        $this->prefix = $prefix;
    }

    /**
     * Finds a file by class name while caching lookups to APC.
     *
     * @param string $class A class name to resolve to file
     * @return mixed|null|string
     */
    public function findFile($class)
    {
        $file = apc_fetch($this->prefix.$class);
        if (false === $file) {
            apc_store($this->prefix.$class, $file = parent::findFile($class));
        }

        return $file;
    }
}

