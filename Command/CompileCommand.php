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

        $this->addArgument('bundleName', InputArgument::REQUIRED, 'Bundle where the Definition is located');
        $this->addArgument('definition', InputArgument::REQUIRED, 'Definition class name');

        $this->addOption('server', null, InputOption::VALUE_NONE, 'Generate server classes');
        $this->addOption('namespace', null, InputOption::VALUE_REQUIRED, 'Namespace prefix');

        $this->addOption('bundleNameOut', null, InputOption::VALUE_OPTIONAL,
                'Bundle where the Model will be located (default is the same than the definitions');
	}

    protected function execute(InputInterface $input, OutputInterface $output)
	{
        $bundleName      = $input->getArgument('bundleName');
        $bundle          = $this->getContainer()->get('kernel')->getBundle($bundleName);
        $bundlePath      = $bundle->getPath();

        $definitionPath  = $bundlePath . '/Definition/' . $input->getArgument('definition') . '.thrift';

        $bundleName      = ($input->getOption('bundleNameOut')) ? $input->getOption('bundleNameOut') : $input->getArgument('bundleName');
        $bundle          = $this->getContainer()->get('kernel')->getBundle($bundleName);
        $bundlePath      = $bundle->getPath();

        $modelPath       = $bundlePath . '/Model/';

        $options = $input->getOption('server') ? 'oop,namespace,server,autoload' : 'oop,namespace,autoload';

        //Add namespace prefix if needed
        if($input->getOption('namespace'))
        {
            $options.= ',nsglobal=' . escapeshellarg($input->getOption('namespace'));
        }

        exec(sprintf('rm -rf %s/%s/*', $modelPath, $input->getArgument('definition')));

        exec(sprintf('%s -r -v --gen php:%s --out %s %s 2>&1',
            self::THRIFT_EXEC,
            $options,
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
        }
    }
}
