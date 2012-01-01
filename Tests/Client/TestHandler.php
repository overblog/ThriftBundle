<?php

namespace Overblog\ThriftBundle\Tests\Client;

use ThriftModel\Test\Test;
use Overblog\ThriftBundle\Factory\ThriftFactory;

class TestHandler
{
    protected $factory;

    public function __construct(ThriftFactory $factory)
    {
        $this->factory = $factory;
    }

    public function ping()
    {

    }

    public function get($id)
    {
        if($id == -1)
        {
            $e = $this->factory->getInstance('test', 'ThriftModel\Test\InvalidValueException', array(
                'error_code' => 100,
                'error_msg' => 'ERROR'
            ));

            throw $e;
        }

        $test = $this->factory->getInstance('test', 'ThriftModel\Test\Test', array(
            'id' => $id,
            'content' => 'TEST'
        ));

        return $test;
    }

    public function getList($id)
    {
        $test = $this->get($id);

        $test1 = clone $test;

        $test1->content = 'TEST2';

        return array($test, $test1);
    }

    public function create($test)
    {
        if(empty($test->content))
        {
            $e = $this->factory->getInstance('test', 'ThriftModel\Test\InvalidValueException', array(
                'error_code' => 100,
                'error_msg' => 'ERROR'
            ));

            throw $e;
        }

        return true;
    }
}