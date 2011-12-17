<?php

namespace Overblog\ThriftBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Server THRIFT
 *
 * @link https://github.com/yuxel/thrift-examples
 * @link http://svn.apache.org/repos/asf/thrift/trunk/
 */

use Thrift\Server\TServerSocket;
use Thrift\Factory\TTransportFactory;
use Thrift\Factory\TBinaryProtocolFactory;
use Thrift\Server\TForkingServer;

use Overblog\ThriftBundle\Model\Comment\Processor\CommentProcessor;

class ServerCommand extends ContainerAwareCommand
{
    protected function configure()
	{
        $this->setName('thrift:server')
		  ->setDescription('Start Thrift Server');
	}

    protected function execute(InputInterface $input, OutputInterface $output)
	{
        $handler = $this->getContainer()->get('overblog_api.extension.comment');
        $processor = new CommentProcessor($handler);

        header('Content-Type: application/x-thrift');

        $transport = new TServerSocket();
        $outputTransportFactory = $inputTransportFactory = new TTransportFactory($transport);
        $outputProtocolFactory = $inputProtocolFactory = new TBinaryProtocolFactory();

        $server = new TForkingServer(
            $processor,
            $transport,
            $inputTransportFactory,
            $outputTransportFactory,
            $inputProtocolFactory,
            $outputProtocolFactory
        );
        $server->serve();
    }
}