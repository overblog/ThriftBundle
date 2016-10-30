<?php

/*
 * This file is part of the OverblogThriftBundle package.
 *
 * (c) Overblog <http://github.com/overblog/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Overblog\ThriftBundle\Tests\Client;

use Overblog\ThriftBundle\Factory\ThriftFactory;
use ThriftModel\Test\Test;

class TestHandler
{
    protected $factory;

    public function __construct(ThriftFactory $factory)
    {
        $this->factory = $factory;
    }

    public function ping()
    {
        return true;
    }

    public function get($id)
    {
        if ($id == -1) {
            /** @var \ThriftModel\Test\InvalidValueException $e */
            $e = $this->factory->getInstance('ThriftModel\Test\InvalidValueException', [
                'error_code' => 100,
                'error_msg' => 'ERROR',
            ]);

            throw $e;
        }

        $test = $this->factory->getInstance('ThriftModel\Test\Test', [
            'id' => $id,
            'content' => 'TEST',
        ]);

        return $test;
    }

    public function getList($id)
    {
        $test = $this->get($id);

        $test1 = clone $test;

        $test1->content = 'TEST2';

        return [$test, $test1];
    }

    public function create($test)
    {
        if (empty($test->content)) {
            /** @var \ThriftModel\Test\InvalidValueException $e */
            $e = $this->factory->getInstance('ThriftModel\Test\InvalidValueException', [
                'error_code' => 100,
                'error_msg' => 'ERROR',
            ]);

            throw $e;
        }

        return true;
    }
}
