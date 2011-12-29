<?php

namespace Overblog\ThriftBundle\Factory;

/**
 * Test factory
 *
 * @author Xavier HAUSHERR
 */

class ThriftFactory
{
    protected function __construct(){}

    /**
     * Return an instance of a Thrift Model Class
     * @param string $classe
     * @param mixed $param
     * @return Object
     */
    public static function getInstance($classe, $param = null)
    {
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