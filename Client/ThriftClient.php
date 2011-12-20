<?php

namespace Overblog\ThriftBundle\Client;

use Thrift\Transport\TSocket;
use Thrift\Transport\TSocketPool;
use Thrift\Transport\THttpClient;

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

    public function getClient($name)
    {
        if(!isset($this->handler[$name]))
        {
            if(isset($this->clients[$name]))
            {
                $nbHosts = count($this->clients[$name]['hosts']);

                /**
                 * Initialisation du socket
                 */
                switch($this->clients[$name]['type'])
                {
                    case 'socket':
                        if($nbHosts == 1)
                        {
                            $host = current($this->clients[$name]['hosts']);

                            $socket = new TSocket($host['host'], $host['port']);
                        }
                        else
                        {
                            $hosts = array();
                            $ports = array();

                            foreach($this->clients[$name]['hosts'] as $host)
                            {
                                $hosts[] = $host['host'];
                                $ports[] = $host['port'];
                            }

                            $socket = new TSocketPool($hosts, $ports);
                        }

                        break;

                    case 'http':
                    default:

                        if($nbHosts > 1)
                        {
                            throw new \Exception('Http client can onlt take one host');
                        }

                        $host = current($this->clients[$name]['hosts']);

                        $url = parse_url($this->clients[$name]['type'] . '://' . $host['host']);

                        $socket = new THttpClient($url['host'], $host['port'], $url['path']);
                        break;
                }

                $client = array();

                $client['transport'] = new TBufferedTransport($socket, 1024, 1024);

                $protocol = new $this->clients[$name]['protocol']($client['transport']);

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