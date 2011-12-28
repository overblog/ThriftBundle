<?php

namespace Overblog\ThriftBundle\Factory;

/**
 * Test factory
 */

class ThriftFactory
{
    protected function __construct(){}

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