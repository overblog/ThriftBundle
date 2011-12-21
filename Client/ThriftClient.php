<?php

namespace Overblog\ThriftBundle\Client;

use Overblog\ThriftBundle\Exception\ConfigurationException;

use Thrift\Transport\TMemoryBuffer;
use Thrift\Transport\TNullTransport;
use Thrift\Transport\TFramedTransport;
use Thrift\Transport\TBufferedTransport;

class ThriftClient
{
    protected $clients = array();
    protected $handler = array();

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
                $client = new $this->clients[$name]['client']($protocol);

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