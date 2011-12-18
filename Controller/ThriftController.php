<?php
namespace Overblog\ThriftBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Thrift\Transport\TBufferedTransport;
use Thrift\Transport\TPhpStream;
use Thrift\Protocol\TBinaryProtocolAccelerated;

use Overblog\ThriftBundle\Model\Comment\Processor\CommentProcessor;

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

        $handler = $this->get($config['service']);
        $processor = new $config['processor']($handler);

        header('Content-Type: application/x-thrift');

        $transport = new TBufferedTransport(new TPhpStream(TPhpStream::MODE_R | TPhpStream::MODE_W));
        $protocol = new TBinaryProtocolAccelerated($transport, true, true);

        $transport->open();
        $processor->process($protocol, $protocol);
        $transport->close();

        die();
    }
}
