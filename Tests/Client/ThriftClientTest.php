<?php
namespace Overblog\ThriftBundle\Tests\Client;

use Overblog\ThriftBundle\Tests\ThriftBundleTestCase;
use Overblog\ThriftBundle\Factory\ThriftFactory;
use Overblog\ThriftBundle\Client\ThriftClient;
use Overblog\ThriftBundle\Tests\Client\TestHandler;

use Thrift\Server\TServerSocket;
use Thrift\Factory\TTransportFactory;
use Thrift\Factory\TBinaryProtocolFactory;
use Thrift\Server\TSimpleServer;

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

        $this->factory = new ThriftFactory(array(
            'test' => array(
                'definition' => 'Test',
                'className' => 'TestService',
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
                'className' => 'TestService',
                'namespace' => 'ThriftModel\Test',
                'protocol' => 'Thrift\\Protocol\\TBinaryProtocolAccelerated'
            )
        ));

        $this->assertInstanceOf('ThriftModel\Test\TestServiceClient', $thriftClient->getClient());

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

    protected function createSocketServer()
    {
        return new ThriftClient($this->factory, array(
            'service' => 'test',
            'type' => 'socket',
            'hosts' => array(
                'test' => array(
                    'host' => 'localhost',
                    'port' => 9090,
                    'recvTimeout' => 1000
                )
            ),
            'service_config' => array(
                'definition' => 'Test',
                'className' => 'Test',
                'namespace' => 'ThriftModel\Test',
                'protocol' => 'Thrift\\Protocol\\TBinaryProtocolAccelerated'
            )
        ));
    }

    public function testSocketClient__NoServer()
    {
        $thriftClient = $this->createSocketServer();

        // Server doesn't exists
        $this->setExpectedException('Thrift\Exception\TException',
			'TSocket: Could not connect to localhost:9090 (Connexion refusée [111])'
		);

        $this->assertInstanceOf('ThriftModel\Test\TestServiceClient', $thriftClient->getClient());
    }

    public function testSocketClient()
    {
        $thriftClient = $this->createSocketServer();

        $this->assertInstanceOf(
            'ThriftModel\Test\Test',
            $thriftClient->getFactory('ThriftModel\Test\Test')
        );

        //$pid = pcntl_fork();
        $handler = new TestHandler($this->factory);
        $processor = $this->factory->getProcessorInstance('test', $handler);

        $this->assertInstanceOf(
            'ThriftModel\Test\TestServiceProcessor',
            $processor
        );

        $transport = new TServerSocket('localhost', 9090);
        $outputTransportFactory = $inputTransportFactory = new TTransportFactory($transport);
        $outputProtocolFactory = $inputProtocolFactory = new TBinaryProtocolFactory();

        $server = new TSimpleServer(
            $processor,
            $transport,
            $inputTransportFactory,
            $outputTransportFactory,
            $inputProtocolFactory,
            $outputProtocolFactory
        );

        $pid = pcntl_fork();

        if ($pid > 0)
        {
            //Wait for the server to launch
            sleep(2);

            $client = $thriftClient->getClient();
            $this->assertInstanceOf('ThriftModel\Test\TestServiceClient', $client);

            // Void Method
            $this->assertNull($client->ping());

            // Return test object
            $test = $client->get(1);
            $this->assertInstanceOf('ThriftModel\Test\Test', $test);
            $this->assertEquals(1, $test->id);
            $this->assertEquals('TEST', $test->content);

            // Wrong ID return Exception
            try
            {
                $response = $client->get(-1);;
            }
            catch(\Exception $e)
            {
                $this->assertInstanceOf('ThriftModel\Test\InvalidValueException', $e);
            }

            // Return array of test object
            $test = $client->getList(1);
            $this->assertInternalType('array', $test);
            $this->assertCount(2, $test);
            $this->assertContainsOnly('ThriftModel\Test\Test', $test);
            $this->assertEquals(1, $test[0]->id);
            $this->assertEquals('TEST', $test[0]->content);
            $this->assertEquals(1, $test[1]->id);
            $this->assertEquals('TEST2', $test[1]->content);

            // Wrong ID return Exception
            try
            {
                $response = $client->getList(-1);;
            }
            catch(\Exception $e)
            {
                $this->assertInstanceOf('ThriftModel\Test\InvalidValueException', $e);
            }

            //Create test
            $testObject = $this->factory->getInstance('ThriftModel\Test\Test', array(
                'content' => 'OK'
            ));

            $test = $client->create($testObject);
            $this->assertTrue((bool)$test);

            $testObject->content = '';

            // Wrong ID return Exception
            try
            {
                $response = $client->create($testObject);;
            }
            catch(\Exception $e)
            {
                $this->assertInstanceOf('ThriftModel\Test\InvalidValueException', $e);
            }

            posix_kill($pid, SIGTERM);

            pcntl_wait($status, WNOHANG);
        }
        elseif ($pid === 0)
        {
            $server->serve();
            $transport->close();

            posix_kill($pid, SIGTERM);

            exit(0);
        }
    }


    protected function onNotSuccessfulTest(\Exception $e)
    {
        parent::onNotSuccessfulTest($e);
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
                'className' => 'TestService',
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