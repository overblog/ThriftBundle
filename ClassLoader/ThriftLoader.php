<?php

namespace Overblog\ThriftBundle\ClassLoader;

use Overblog\ThriftBundle\CacheWarmer\ThriftCompileCacheWarmer;

/**
 * Unfortunately, we can't extends UniversalClassLoader because of
 * the debug version... :-(
 */

class ThriftLoader
{
    private $namespaces = array();

    /**
     * Registers an array of namespaces
     *
     * @param array $namespaces An array of namespaces (namespaces as keys and locations as values)
     *
     * @api
     */
    public function registerNamespaces(array $namespaces)
    {
        foreach ($namespaces as $namespace => $locations) {
            $this->namespaces[$namespace] = (array) $locations;
        }
    }

    /**
     * Registers this instance as an autoloader.
     *
     * @param Boolean $prepend Whether to prepend the autoloader or not
     *
     * @api
     */
    public function register($prepend = false)
    {
        spl_autoload_register(array($this, 'loadClass'), true, $prepend);
    }

    /**
     * Finds the path to the file where the class is defined.
     *
     * @param string $class The name of the class
     *
     * @return string|null The path, if found
     */
    public function findFile($classNs)
    {
        $m = explode('\\', $classNs);

        // Ignore wrong call
        if(count($m) <= 1)
        {
            return;
        }

        $class = array_pop($m);
        $namespace = implode('\\', $m);

        foreach ($this->namespaces as $ns => $dirs)
        {
            //Don't interfere with other autoloaders
            if (0 !== strpos($classNs, $ns))
            {
                continue;
            }

            foreach ($dirs as $dir) {
                /**
                 * Présent dans le service
                 * Interface
                 * Client
                 * Processor
                 */
                if(0 === preg_match('#(.+)(if|client|processor)$#i', $class, $n))
                {
                    $className = 'Types';
                }
                else
                {
                    $className = $n[1];
                }

                $file = $dir .
                        DIRECTORY_SEPARATOR .
                        ThriftCompileCacheWarmer::CACHE_SUFFIX .
                        DIRECTORY_SEPARATOR .
                        str_replace('\\', DIRECTORY_SEPARATOR, $namespace) .
                        DIRECTORY_SEPARATOR .
                        $className . '.php';

                if(file_exists($file))
                {
                    return $file;
                }
            }
        }
    }

    /**
     * Loads the given class or interface.
     *
     * @param string $class The name of the class
     */
    public function loadClass($class)
    {
        if (($file = $this->findFile($class))) {
            require_once $file;
        }
    }
}