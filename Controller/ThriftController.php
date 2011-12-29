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

        $services = $this->container->getParameter('thrift.config.services');

        if(!isset($services[$extensionName]))
        {
            throw $this->createNotFoundException(sprintf('Unknown config "%s"', $extensionName));
        }

        $config = $services[$extensionName];

        $server = new HttpServer(
            $this->container->get('thrift.factory')->getInstance($config['processor'], $this->container->get($config['service'])),
            $config
        );

        $server->getHeader();

        $server->run();

        // Much faster than return a Symfony Response
        exit(0);
    }
}
