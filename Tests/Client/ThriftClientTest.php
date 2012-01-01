<?php
namespace Overblog\ThriftBundle\Tests\Client;

use Overblog\ThriftBundle\Tests\ThriftBundleTestCase;
use Overblog\ThriftBundle\Factory\ThriftFactory;
use Overblog\ThriftBundle\Client\ThriftClient;

/**
 * UNIT TEST
 *
 * @author Xavier HAUSHERR
 */
class ThriftClientTest extends ThriftBundleTestCase
{
    protected $factory;

    protected function setUp()
    {
        parent::setUp();
        parent::compile();

        $this->factory = new ThriftFactory(__DIR__ . '/..', array(
            'test' => array(
                'definition' => 'Test',
                'namespace' => 'ThriftModel\Test'
            )
        ));
    }

    public function testHttpClient()
    {
        $thriftClient = new ThriftClient($this->factory, array(
            'service' => 'test',
            'type' => 'http',
            'hosts' => array(
                'test' => array(
                    'host' => 'localhost/thrift',
                    'port' => 80
                )
            ),
            'service_config' => array(
                'definition' => 'Test',
                'namespace' => 'ThriftModel\Test',
                'protocol' => 'Thrift\\Protocol\\TBinaryProtocolAccelerated'
            )
        ));

        $this->assertInstanceOf('ThriftModel\Test\TestClient', $thriftClient->getClient());

        $this->assertInstanceOf(
            'ThriftModel\Test\Test',
            $thriftClient->getFactory('ThriftModel\Test\Test')
        );

        // Server doesn't exists so it return an exception
        $this->setExpectedException('Thrift\Exception\TTransportException',
			'THttpClient: Could not connect to localhost/thrift'
		);

        $thriftClient->getClient()->ping();
    }

    public function testSocketClient()
    {
        $thriftClient = new ThriftClient($this->factory, array(
            'service' => 'test',
            'type' => 'socket',
            'hosts' => array(
                'test' => array(
                    'host' => 'localhost',
                    'port' => 9090
                )
            ),
            'service_config' => array(
                'definition' => 'Test',
                'namespace' => 'ThriftModel\Test',
                'protocol' => 'Thrift\\Protocol\\TBinaryProtocolAccelerated'
            )
        ));

        $this->assertInstanceOf(
            'ThriftModel\Test\Test',
            $thriftClient->getFactory('ThriftModel\Test\Test')
        );

        // Server doesn't exists
        $this->setExpectedException('Thrift\Exception\TException',
			'TSocket: Could not connect to localhost:9090 (Connexion refusée [111])'
		);

        $this->assertInstanceOf('ThriftModel\Test\TestClient', $thriftClient->getClient());
    }

    public function testMultiSocketClient()
    {
        $thriftClient = new ThriftClient($this->factory, array(
            'service' => 'test',
            'type' => 'socket',
            'hosts' => array(
                'test' => array(
                    'host' => 'localhost',
                    'port' => 9090
                ),
                'test2' => array(
                    'host' => 'localhost',
                    'port' => 9091
                )
            ),
            'service_config' => array(
                'definition' => 'Test',
                'namespace' => 'ThriftModel\Test',
                'protocol' => 'Thrift\\Protocol\\TBinaryProtocolAccelerated'
            )
        ));

        $this->assertInstanceOf(
            'ThriftModel\Test\Test',
            $thriftClient->getFactory('ThriftModel\Test\Test')
        );

        // Server doesn't exists
        try
        {
            $thriftClient->getClient();
        }
        catch(\Exception $e)
        {
            $this->assertInstanceOf('Thrift\Exception\TException', $e);
        }
    }
}