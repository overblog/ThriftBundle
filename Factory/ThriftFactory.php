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

    private $memoryDef = array();

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
     * Return cache dir for namespace
     * @param type $namespace
     * @return type
     */
    protected function getCacheDir($namespace)
    {
        return  $this->cacheDir .
                DIRECTORY_SEPARATOR .
                str_replace('\\', DIRECTORY_SEPARATOR, $namespace) .
                DIRECTORY_SEPARATOR;
    }

    /**
     * Load Thrift cache Files
     */
    protected function loadFiles($service, $classe)
    {
        preg_match('#^(.+)\\\.+?$#', $classe, $m);

        $path = $this->getCacheDir($m[1]);

        if(
            !array_key_exists($path.$service, $this->memoryDef) &&
            file_exists($path . $this->services[$service]['definition'] . '.php')
        )
        {
            require_once($path . $this->services[$service]['definition'] . '.php');
        }

        require_once($path . 'Types.php');

        //Set memory
        $this->memoryDef[$path.$service] = 1;
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
        $this->loadFiles($service, $classe);

        if(is_null($param))
        {
            return new $classe();
        }
        else
        {
            return new $classe($param);
        }
    }

    /**
     * Return a processor instance
     * @param string $service
     * @param mixed $handler
     * @return Object
     */
    public function getProcessorInstance($service, $handler)
    {
        $classe = sprintf('%s\%sProcessor', $this->services[$service]['namespace'], $this->services[$service]['definition']);

        $this->loadFiles($service, $classe);

        return new $classe($handler);
    }

    /**
     * Return a client instance
     * @param string $service
     * @param Thrift\Protocol\TProtocol $transport
     * @return Object
     */
    public function getClientInstance($service, $protocol)
    {
        $classe = sprintf('%s\%sClient', $this->services[$service]['namespace'], $this->services[$service]['definition']);

        $this->loadFiles($service, $classe);

        return new $classe($protocol);
    }
}