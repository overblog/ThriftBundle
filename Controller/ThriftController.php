<?php
namespace Overblog\ThriftBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Overblog\ThriftBundle\Server\HttpServer;

/**
 * Http Server controller
 * @author Xavier HAUSHERR
 */

class ThriftController extends Controller
{
    /**
     * HTTP Entry point
     */
    public function serverAction()
    {
        if(!($extensionName = $this->getRequest()->get('extensionName')))
        {
            throw $this->createNotFoundException('Unable to get config name');
        }

        $servers = $this->container->getParameter('thrift.config.servers');

        if(!isset($servers[$extensionName]))
        {
            throw $this->createNotFoundException(sprintf('Unknown config "%s"', $extensionName));
        }

        $server = $servers[$extensionName];

        $server = new HttpServer(
            $this->container->get('thrift.factory')->getInstance(
                $server['service'],
                sprintf('%sProcessor', $server['service_config']['definition']),
                $this->container->get($server['handler'])
            ),
            $server['service_config']
        );

        $server->getHeader();

        $server->run();

        // Much faster than return a Symfony Response
        exit(0);
    }
}
