<?php

namespace Overblog\ThriftBundle\ClassLoader;

use Symfony\Component\ClassLoader\UniversalClassLoader;

class ThriftLoader extends UniversalClassLoader
{
    public function findFile($class)
    {
        preg_match('#^(.+)\\\(.+?)$#', $class, $m);

        foreach ($this->getNamespaces() as $ns => $dirs) {
            foreach ($dirs as $dir) {
                /**
                 * Présent dans le service
                 * Interface
                 * Client
                 * Processor
                 */
                if(0 === preg_match('#(.+)(interface|client|processor)$#i', $m[2], $n))
                {
                    $className = 'Types';
                }
                else
                {
                    $className = $n[1];
                }

                $namespace = $m[1];

                $file = $dir .
                        DIRECTORY_SEPARATOR .
                        str_replace('\\', DIRECTORY_SEPARATOR, $namespace) .
                        DIRECTORY_SEPARATOR .
                        str_replace('_', DIRECTORY_SEPARATOR, $className) .
                        '.php';

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