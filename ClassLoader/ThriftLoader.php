<?php

namespace Overblog\ThriftBundle\ClassLoader;

use Symfony\Component\ClassLoader\UniversalClassLoader;

class ThriftLoader extends UniversalClassLoader
{
    public function findFile($classNs)
    {
        $m = explode('\\', $classNs);

        $namespace = $m[0] . '\\' . $m[1];
        $class = end($m);

        foreach ($this->getNamespaces() as $ns => $dirs)
        {
            //Don't interfere with other autoloaders
            if (0 !== strpos($classNs, $ns))
            {
                return;
            }

            foreach ($dirs as $dir) {
                /**
                 * Présent dans le service
                 * Interface
                 * Client
                 * Processor
                 */
                if(0 === preg_match('#(.+)(interface|client|processor)$#i', $class, $n))
                {
                    $className = 'Types';
                }
                else
                {
                    $className = $n[1];
                }

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