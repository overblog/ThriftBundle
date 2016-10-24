<?php

/*
 * This file is part of the OverblogThriftBundle package.
 *
 * (c) Overblog <http://github.com/overblog/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Overblog\ThriftBundle\Controller;

use Overblog\ThriftBundle\Server\HttpServer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Http Server controller.
 *
 * @author Xavier HAUSHERR
 */
class ThriftController extends Controller
{
    /**
     * HTTP Entry point.
     */
    public function serverAction(Request $request)
    {
        if (!($extensionName = $request->get('extensionName'))) {
            throw $this->createNotFoundException('Unable to get config name');
        }

        $servers = $this->container->getParameter('thrift.config.servers');

        if (!isset($servers[$extensionName])) {
            throw $this->createNotFoundException(sprintf('Unknown config "%s"', $extensionName));
        }

        $server = $servers[$extensionName];

        $server = new HttpServer(
            $this->container->get('thrift.factory')->getProcessorInstance(
                $server['service'],
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
