<?php
namespace Overblog\ThriftBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Overblog\ThriftBundle\Client\ThriftClient;

class ClientTestCommand extends ContainerAwareCommand
{
    protected function configure()
	{
        $this->setName('thrift:client:test')
		  ->setDescription('Test Thrift methods');

        $this->addArgument('service', InputArgument::REQUIRED, 'Service name');
        $this->addArgument('method', InputArgument::REQUIRED, 'Method name');
        $this->addArgument('args', InputArgument::IS_ARRAY, 'Method args');

        $this->addOption('host', 't', InputOption::VALUE_REQUIRED, 'Host to listen on', 'localhost');
        $this->addOption('port', 'p', InputOption::VALUE_REQUIRED, 'Port to listen on', 9090);
        $this->addOption('recvTimeout', 'r', InputOption::VALUE_OPTIONAL, 'Data receive Timeout');
	}

    protected function execute(InputInterface $input, OutputInterface $output)
	{
        $services = $this->getContainer()->getParameter('thrift.config.services');
        $service  = $input->getArgument('service');
        $method   = $input->getArgument('method');
        $args     = $input->getArgument('args');

        if(!isset($services[$service]))
        {
            $output->writeln(sprintf('<error>Unknow service: %s</error>', $service));
            return false;
        }

        // Instantiate client
        $thriftClient = new ThriftClient(
            $this->getContainer()->get('thrift.factory'),
            array(
                'service_config' => $services[$service],
                'service' => $service,
                'type' => 'socket',
                'hosts' => array(
                    $service => array(
                        'host' => $input->getOption('host'),
                        'port' => $input->getOption('port'),
                        'recvTimeout' => $input->getOption('recvTimeout'),
                    )
                )
            )
        );

        $time_start = microtime(true);

        try
        {
            $client = $thriftClient->getClient();

            if(count($args) > 0)
            {
                $result = call_user_func_array(array($client, $method), $args);
            }
            else
            {
                $result = call_user_func(array($client, $method));
            }

            $end = (microtime(true) - $time_start);

            $output->writeln(print_r($result, true));
            $output->writeln(sprintf('<info>Time taken for request: %s ms</info>', $end));

        }
        catch(\ThriftModel\User\InvalidValueException $e)
        {
            $output->writeln(sprintf('<error>Error Code: %s</error>', $e->getCode()));
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
        }
        catch(\Thrift\Exception\TException $e)
        {
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
            $output->writeln(sprintf('<info>Have you started the server with: php app/console thrift:server %s ?</info>', $service));
            return false;
        }
        catch(\Exception $e)
        {
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
        }
        //TODO : Missing return statement
    }
}