<?php

namespace Overblog\ThriftBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Overblog\ThriftBundle\Server\SocketServer;
use Overblog\ThriftBundle\Factory\ThriftFactory;

/**
 * Socket server command
 * @author Xavier HAUSHERR
 */

class ServerCommand extends ContainerAwareCommand
{
    /**
     * Configure the command
     */
    protected function configure()
	{
        $this->setName('thrift:server')
		  ->setDescription('Start Thrift Server');

        $this->addArgument('config', InputArgument::REQUIRED, 'Config key');

        $this->addOption('host', 't', InputOption::VALUE_REQUIRED, 'Host to listen on', 'localhost');
        $this->addOption('port', 'p', InputOption::VALUE_REQUIRED, 'Port to listen on', 9090);
	}

    /**
     * Execute server
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
	{
        $services = $this->getContainer()->getParameter('thrift.config.services');
        $config = $services[$input->getArgument('config')];

        $server = new SocketServer(
            ThriftFactory::getInstance($config['processor'], $this->getContainer()->get($config['service'])),
            $config
        );

        $server->getHeader();

        $server->run($input->getOption('host'), $input->getOption('port'));
    }
}