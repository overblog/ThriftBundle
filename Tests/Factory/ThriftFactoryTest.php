<?php

/*
 * This file is part of the OverblogThriftBundle package.
 *
 * (c) Overblog <http://github.com/overblog/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Overblog\ThriftBundle\Tests\Factory;

use Overblog\ThriftBundle\Factory\ThriftFactory;
use Overblog\ThriftBundle\Metadata\Metadata;
use Overblog\ThriftBundle\Tests\ThriftBundleTestCase;

/**
 * UNIT TEST.
 *
 * @author Xavier HAUSHERR
 */
class ThriftFactoryTest extends ThriftBundleTestCase
{
    protected function setUp()
    {
        parent::setUp();
        parent::compile();
    }

    public function testFactory()
    {
        $factory = new ThriftFactory(new Metadata([
            'services' => [
                'test' => [
                    'definition' => 'Test',
                    'className' => 'TestService',
                    'namespace' => 'ThriftModel\Test',
                ],
            ],
        ]));

        $this->assertInstanceOf(
            'ThriftModel\Test\Test',
            $factory->getInstance('ThriftModel\Test\Test')
        );

        $this->assertInstanceOf(
            'ThriftModel\Test\Test',
            $factory->getInstance('ThriftModel\Test\Test', [])
        );

        $this->assertInstanceOf(
            'ThriftModel\Test\State',
            $factory->getInstance('ThriftModel\Test\State')
        );

        $this->assertInstanceOf(
            'ThriftModel\Test\InvalidValueException',
            $factory->getInstance('ThriftModel\Test\InvalidValueException')
        );

        $this->assertInstanceOf(
            'ThriftModel\Test\TestServiceProcessor',
            $factory->getProcessorInstance('test', null)
        );

        $this->assertInstanceOf(
            'ThriftModel\Test\TestServiceClient',
            $factory->getClientInstance('test', null)
        );
    }
}
