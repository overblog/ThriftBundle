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

use Overblog\ThriftBundle\Factory\ThriftFactory;
use Overblog\ThriftBundle\Metadata\Exception\ServerNotFoundException;
use Overblog\ThriftBundle\Server\HttpServer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
        /**
         * @var ThriftFactory
         */
        $factory = $this->container->get('thrift.factory');
        $metadata = $factory->getMetadata();

        try {
            $serverMetadata = $metadata->getServer($extensionName);
        } catch (ServerNotFoundException $e) {
            throw $this->createNotFoundException(sprintf('Unknown config "%s"', $extensionName), $e);
        }

        $response = new StreamedResponse();
        $response->headers->set('Content-Type', 'application/x-thrift');

        $response->setCallback(function () use ($factory, $serverMetadata, $metadata, $request) {
            $server = new HttpServer(
                $factory->getProcessorInstance(
                    $serverMetadata->getService(),
                    $this->container->get($serverMetadata->getHandler())
                )
            );

            $server->run($metadata->getService($serverMetadata->getService())->getProtocol(), $request->getContent(true));
        });

        return $response;
    }
}
