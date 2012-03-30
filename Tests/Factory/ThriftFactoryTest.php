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
        $factory = new ThriftFactory(array(
            'test' => array(
                'definition' => 'Test',
                'namespace' => 'ThriftModel\Test'
            )
        ));
        $factory->initLoader(array(
            'ThriftModel' => __DIR__ . '/..'
        ));

        $this->assertInstanceOf(
            'ThriftModel\Test\Test',
            $factory->getInstance('ThriftModel\Test\Test')
        );

        $this->assertInstanceOf(
            'ThriftModel\Test\Test',
            $factory->getInstance('ThriftModel\Test\Test', array())
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
            'ThriftModel\Test\TestProcessor',
            $factory->getProcessorInstance('test', null)
        );

        $this->assertInstanceOf(
            'ThriftModel\Test\TestClient',
            $factory->getClientInstance('test', null)
        );
    }
}
