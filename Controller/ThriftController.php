<?php
namespace Overblog\ThriftBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Overblog\ThriftBundle\Server\HttpServer;

class ThriftController extends Controller
{
    /**
     * HTTP Entry point
     */
    public function serverAction()
    {
        if(!$this->getRequest()->get('config'))
        {
            throw new \Exception('Unable to get config name');
        }

        $services = $this->container->getParameter('thrift.services');
        $config = $services[$this->getRequest()->get('config')];

        $processor = new HttpServer(
            $this->get($config['processor']),
            $config
        );

        $processor->getHeader();

        $processor->run();

        // Much faster than return a Symfony Response
        exit(0);
    }
}
