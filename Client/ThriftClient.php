<?php

namespace Overblog\ThriftBundle\Client;

use Thrift\Transport\TSocket;
use Thrift\Transport\THttpClient;
use Thrift\Transport\TBufferedTransport;
use Thrift\Protocol\TBinaryProtocolAccelerated;

class ThriftClient
{
    protected $clients = array();
    protected $handler = array();

    public function __construct(Array $clients)
    {
        $this->clients = $clients;
    }

    public function getClient($name)
    {
        if(!isset($this->handler[$name]))
        {
            if(isset($this->clients[$name]))
            {
                switch($this->clients[$name]['type'])
                {
                    case 'socket':
                        $socket = new TSocket($this->clients[$name]['host'], $this->clients[$name]['port']);
                        break;

                    case 'http':
                    default:
                        $url = parse_url($this->clients[$name]['type'] . '://' . $this->clients[$name]['host']);

                        $socket = new THttpClient($url['host'], $this->clients[$name]['port'], $url['path']);
                        break;
                }

                $client = array();

                $client['transport'] = new TBufferedTransport($socket, 1024, 1024);
                $protocol = new TBinaryProtocolAccelerated($client['transport']);

                $client['client'] = new $this->clients[$name]['client']($protocol);

                $client['transport']->open();

                $this->handler[$name] = $client;
            }
            else
            {
                throw new \Exception(sprintf('Unknow client "%s"', $name));
            }
        }

        return $this->handler[$name]['client'];
    }

    public function __destruct()
    {
        foreach($this->handler as $client)
        {
            $client['transport']->close();
        }
    }
}