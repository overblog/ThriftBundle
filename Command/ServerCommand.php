<?php

namespace Overblog\ThriftBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Server THRIFT
 */

use Thrift\Server\TServerSocket;
use Thrift\Factory\TTransportFactory;
use Thrift\Factory\TBinaryProtocolFactory;
use Thrift\Server\TForkingServer;

class ServerCommand extends ContainerAwareCommand
{
    protected function configure()
	{
        $this->setName('thrift:server')
		  ->setDescription('Start Thrift Server');

        $this->addArgument('config', InputArgument::REQUIRED, 'Config key');

        $this->addOption('host', 't', InputOption::VALUE_REQUIRED, 'Host to listen on', 'localhost');
        $this->addOption('port', 'p', InputOption::VALUE_REQUIRED, 'Port to listen on', 9090);
	}

    protected function execute(InputInterface $input, OutputInterface $output)
	{
        $services = $this->getContainer()->getParameter('thrift.services');
        $config = $services[$input->getArgument('config')];

        $handler = $this->getContainer()->get($config['service']);
        $processor = new $config['processor']($handler);

        $transport = new TServerSocket($input->getOption('host'), $input->getOption('port'));
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