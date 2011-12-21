<?php
namespace Overblog\ThriftBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Overblog\ThriftBundle\Compiler\ThriftCompiler;

class CompileCommand extends ContainerAwareCommand
{
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
        $compiler = new ThriftCompiler();
        $definition = $input->getArgument('definition');

        $bundleName      = $input->getArgument('bundleName');
        $bundle          = $this->getContainer()->get('kernel')->getBundle($bundleName);
        $bundlePath      = $bundle->getPath();

        $definitionPath  = $bundlePath . '/Definition/' . $definition . '.thrift';

        $bundleName      = ($input->getOption('bundleNameOut')) ? $input->getOption('bundleNameOut') : $input->getArgument('bundleName');
        $bundle          = $this->getContainer()->get('kernel')->getBundle($bundleName);
        $bundlePath      = $bundle->getPath();

        //Set Path
        $compiler->setModelPath(sprintf('%s/Model', $bundlePath));

        // Empty old model
        $compiler->emptyModelPath($definition);

        //Add namespace prefix if needed
        if($input->getOption('namespace'))
        {
            $compiler->setNamespacePrefix($input->getOption('namespace'));
        }

        $return = $compiler->compile($definitionPath, $input->getOption('server'));

        //Error
        if(1 === $return)
        {
            $output->writeln(sprintf('<error>%s</error>', implode("\n", $compiler->getLastOutput())));
        }
        else
        {
            $output->writeln(sprintf('<info>%s</info>', implode("\n", $compiler->getLastOutput())));
        }
    }
}
