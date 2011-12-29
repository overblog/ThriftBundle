<?php

namespace Overblog\ThriftBundle\Factory;

/**
 * Thrift factory
 *
 * @author Xavier HAUSHERR
 */

class ThriftFactory
{
    protected $cacheDir;
    protected $services;
    protected $debug;

    /**
     * Inject dependencies
     * @param string $cacheDir
     * @param boolean $debug
     */
    public function __construct($cacheDir, Array $services, $debug = false)
    {
        $this->cacheDir = $cacheDir;
        $this->services = $services;
        $this->debug = $debug;
    }

    /**
     * Load Thrift cache Files
     */
    protected function loadFiles($service)
    {
        $path = $this->cacheDir .
                DIRECTORY_SEPARATOR .
                str_replace('\\', DIRECTORY_SEPARATOR, $this->services[$service]['namespace']) .
                DIRECTORY_SEPARATOR;

        require_once($path . $this->services[$service]['definition'] . '.php');
        require_once($path . 'Types.php');
    }

    /**
     * Return an instance of a Thrift Model Class
     * @param string $service
     * @param string $classe
     * @param mixed $param
     * @return Object
     */
    public function getInstance($service, $classe, $param = null)
    {
        $this->loadFiles($service);

        $classe = $this->services[$service]['namespace'] . '\\' . $classe;

        if(is_null($param))
        {
            return new $classe();
        }
        else
        {
            return new $classe($param);
        }
    }
}