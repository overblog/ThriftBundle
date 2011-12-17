<?php
namespace Overblog\ThriftBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CompileCommand extends ContainerAwareCommand
{
    /**
     * Thrift Exec Path
     */
    const THRIFT_EXEC = '/usr/local/bin/thrift';

    protected $thriftRelativePath = '/InternalApiBundle/Thrift';

    protected function configure()
	{
        $this->setName('thrift:compile')
		  ->setDescription('Compile Thrift Model for PHP');

        $this->addArgument('definition', InputArgument::REQUIRED, 'Definition class name');

        $this->addOption('language', 'l', InputOption::VALUE_REQUIRED, 'Developement language', 'php');
        $this->addOption('options', 'o', InputOption::VALUE_REQUIRED, 'Developement language options', 'oop,namespace,server,autoload');
	}

    protected function execute(InputInterface $input, OutputInterface $output)
	{
        $basePath  = __DIR__ . '/..';

        $definitionPath = $basePath . '/Definition/' . $input->getArgument('definition') . '.thrift';
        $modelPath = $basePath . '/Model';

        exec(sprintf('rm -rf %s/%s/*', $modelPath, $input->getArgument('definition')));

        exec(sprintf('%s -r -v --gen %s:%s --out %s %s 2>&1',
            self::THRIFT_EXEC,
            $input->getOption('language'),
            $input->getOption('options'),
            $modelPath,
            $definitionPath
        ), $sortie, $return);

        //Error
        if(1 === $return)
        {
            $output->writeln(sprintf('<error>%s</error>', implode("\n", $sortie)));
        }
        else
        {
            $output->writeln(sprintf('<info>%s</info>', implode("\n", $sortie)));

            $filePath = sprintf('%s/%s/%s.php',
                $modelPath,
                $input->getArgument('definition'),
                $input->getArgument('definition')
            );

            //Patch bad file path
//            $type = file_get_contents($filePath);
//
//            $type = preg_replace('#/packages/#', '/../Model/', $type);
//
//            file_put_contents($filePath, $type);
        }
    }
}
