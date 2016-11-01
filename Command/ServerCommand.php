<?php

/*
 * This file is part of the OverblogThriftBundle package.
 *
 * (c) Overblog <http://github.com/overblog/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Overblog\ThriftBundle\Command;

use Overblog\ThriftBundle\Server\SocketServer;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Socket server command.
 *
 * @author Xavier HAUSHERR
 */
class ServerCommand extends ContainerAwareCommand
{
    /**
     * Configure the command.
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
     * Execute server.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return bool
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $config = $input->getArgument('config');
        $metadata = $this->getContainer()->get('thrift.factory')->getMetadata();
        $serverMetadata = $metadata->getServer($config);

        $server = new SocketServer(
            $this->getContainer()->get('thrift.factory')->getProcessorInstance(
                $serverMetadata->getService(),
                $this->getContainer()->get($serverMetadata->getHandler())
            )
        );

        $server->run($input->getOption('host'), $input->getOption('port'), $serverMetadata->isFork());

        return 0;
    }
}
