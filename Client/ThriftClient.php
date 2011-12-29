<?php

namespace Overblog\ThriftBundle\Client;

use Overblog\ThriftBundle\Exception\ConfigurationException;

use Thrift\Transport\TMemoryBuffer;
use Thrift\Transport\TNullTransport;
use Thrift\Transport\TFramedTransport;
use Thrift\Transport\TBufferedTransport;

use Overblog\ThriftBundle\Factory\ThriftFactory;

/**
 * Build client
 * @author Xavier HAUSHERR
 */

class ThriftClient
{
    /**
     * Thrift factory
     * @var ThriftFactory
     */
    protected $factory;

    /**
     * Config
     * @var array
     */
    protected $clients = array();

    /**
     * Handler instances
     * @var array
     */
    protected $handler = array();

    /**
     * Current conf
     * @var string
     */
    protected $currentConf;

    /**
     * Register Dependencies
     * @param array $clients
     */
    public function __construct(ThriftFactory $factory, Array $clients)
    {
        $this->factory = $factory;
        $this->clients = $clients;
    }

    /**
     * Set configuration
     * @param sting $name
     * @return ThriftClient
     */
    public function getService($name)
    {
        if(isset($this->clients[$name]))
        {
            $this->currentConf = $name;
        }
        else
        {
            throw new ConfigurationException(sprintf('Unknow configuration "%s"', $name));
        }

        return $this;
    }

    /**
     * Return client
     * @return Thrift\Transport\TSocket
     */
    public function getClient()
    {
        $name = $this->checkCurrentConf();

        if(!isset($this->handler[$name]))
        {
            $service = $this->clients[$name]['service_config'];

            //Initialisation du client
            $socket = $this->clientFactory($name)->getSocket();

            $transport = new TBufferedTransport($socket, 1024, 1024);

            $client = $this->create(
                sprintf('%sClient', $service['definition']), 
                new $service['protocol']($transport)
            );

            $transport->open();

            $this->handler[$name] = array(
                'transport' => $transport,
                'client' => $client
            );
        }

        return $this->handler[$name]['client'];
    }

    /**
     * Instanciate Thrift Model classes
     * @param string $classe
     * @param mixed $param
     * @return mixed
     */
    public function create($classe, $param = null)
    {
        $name = $this->checkCurrentConf();

        return $this->factory->getInstance($this->clients[$name]['service'], $classe, $param);
    }

    /**
     * Close every connections
     */
    public function __destruct()
    {
        foreach($this->handler as $client)
        {
            $client['transport']->close();
        }
    }

    /**
     * Check if configuration has been correctly set
     * @return string
     */
    protected function checkCurrentConf()
    {
        if(empty($this->currentConf))
        {
            throw new ConfigurationException('Unable to get client');
        }

        return $this->currentConf;
    }

    /**
     * Instanciate client class
     * @param string $name
     * @return Client
     */
    protected function clientFactory($name)
    {
        $class = sprintf('%s\%sClient', __NAMESPACE__, ucfirst(strtolower($this->clients[$name]['type'])));

        return new $class($this->clients[$name]);
    }
}