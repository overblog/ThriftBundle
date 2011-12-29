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
    protected $debug;

    /**
     * Inject dependencies
     * @param string $cacheDir
     * @param boolean $debug
     */
    public function __construct($cacheDir, $debug = false)
    {
        $this->cacheDir = $cacheDir;
        $this->debug = $debug;
    }

    /**
     * Load Thrift cache Files
     */
    protected function loadFiles()
    {
        require_once($this->cacheDir . '/ThriftModel/Comment/Comment.php');
        require_once($this->cacheDir . '/ThriftModel/Comment/Types.php');
    }

    /**
     * Return an instance of a Thrift Model Class
     * @param string $classe
     * @param mixed $param
     * @return Object
     */
    public function getInstance($classe, $param = null)
    {
        $this->loadFiles();

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