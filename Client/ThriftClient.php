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
     * Register Dependencies
     * @param array $clients
     */
    public function __construct(Array $clients)
    {
        $this->clients = $clients;
    }

    /**
     * Return client
     * @param string $name
     * @return Thrift\Transport\TSocket
     */
    public function getClient($name)
    {
        if(!isset($this->handler[$name]))
        {
            if(isset($this->clients[$name]))
            {
                //Initialisation du client
                $clientClass = sprintf('%s\%sClient', __NAMESPACE__, ucfirst(strtolower($this->clients[$name]['type'])));

                $client = new $clientClass($this->clients[$name]);
                $socket = $client->getSocket();

                $transport = new TBufferedTransport($socket, 1024, 1024);

                $protocol = new $this->clients[$name]['protocol']($transport);
                $client = $this->getInstance($this->clients[$name]['client'], $protocol);

                $transport->open();

                $this->handler[$name] = array(
                    'transport' => $transport,
                    'client' => $client
                );
            }
            else
            {
                throw new ConfigurationException(sprintf('Unknow client "%s"', $name));
            }
        }

        return $this->handler[$name]['client'];
    }

    /**
     * Get instance of Thrift Model classes
     * @param string $classe
     * @param mixed $param
     * @return mixed
     */
    public function getInstance($classe, $param = null)
    {
        return ThriftFactory::getInstance($classe, $param);
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
}