<?php
namespace Overblog\ThriftBundle\Tests\Factory;

use Overblog\ThriftBundle\Tests\ThriftBundleTestCase;
use Overblog\ThriftBundle\Factory\ThriftFactory;

/**
 * UNIT TEST
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
        $factory = new ThriftFactory(__DIR__ . '/..', array(
            'test' => array(
                'definition' => 'Test',
                'namespace' => 'ThriftModel\Test'
            )
        ));

        $this->assertInstanceOf(
            'ThriftModel\Test\Test',
            $factory->getInstance('test', 'ThriftModel\Test\Test')
        );

        $this->assertInstanceOf(
            'ThriftModel\Test\Test',
            $factory->getInstance('test', 'ThriftModel\Test\Test', array())
        );

        $this->assertInstanceOf(
            'ThriftModel\Test\State',
            $factory->getInstance('test', 'ThriftModel\Test\State')
        );

        $this->assertInstanceOf(
            'ThriftModel\Test\InvalidValueException',
            $factory->getInstance('test', 'ThriftModel\Test\InvalidValueException')
        );

        $this->assertInstanceOf(
            'ThriftModel\Test\TestProcessor',
            $factory->getProcessorInstance('test', null)
        );

        $this->assertInstanceOf(
            'ThriftModel\Test\TestClient',
            $factory->getClientInstance('test', null)
        );
    }
}
