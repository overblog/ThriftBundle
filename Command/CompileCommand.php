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

use Overblog\ThriftBundle\Compiler\ThriftCompiler;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Compile command to generate thrift model.
 *
 * @author Xavier HAUSHERR
 */
class CompileCommand extends ContainerAwareCommand
{
    /**
     * Configure the command.
     */
    protected function configure()
    {
        $this->setName('thrift:compile')
          ->setDescription('Compile Thrift Model for PHP');

        $this->addArgument('service', InputArgument::REQUIRED, 'Service name');

        $this->addOption('server', null, InputOption::VALUE_NONE, 'Generate server classes');
        $this->addOption('validate', null, InputOption::VALUE_NONE, 'Generate PHP validator methods');
        $this->addOption('namespace', null, InputOption::VALUE_REQUIRED, 'Namespace prefix');
        $this->addOption('path', null, InputOption::VALUE_REQUIRED, 'Thrift exec path');

        $this->addOption('bundleNameOut', null, InputOption::VALUE_OPTIONAL,
                'Bundle where the Model will be located (default is the same than the definitions');
        $this->addOption('includeDir', 'I', InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'Add a directory to the list of directories searched for include directives');
    }

    /**
     * Execute compilation.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $compiler = new ThriftCompiler();

        if (($path = $input->getOption('path'))) {
            $compiler->setExecPath($path);
        }
        $factory = $this->getContainer()->get('thrift.factory');
        $service  = $input->getArgument('service');
        $metadata = $factory->getMetadata();
        $serviceMetadata = $metadata->getService($service);

        // Get definition path
        $definitionPath = $this->getContainer()
                               ->get('thrift.compile_warmer')
                               ->getDefinitionPath($serviceMetadata->getDefinition(), $serviceMetadata->getDefinitionPath());

        // Get out path
        if (($bundleName = $input->getOption('bundleNameOut'))) {
            $bundle          = $this->getContainer()->get('kernel')->getBundle($bundleName);
            $bundlePath      = $bundle->getPath();
        } else {
            $bundlePath = getcwd();
        }

        //Set Path
        $compiler->setModelPath(sprintf('%s/%s', $bundlePath, 'thrift'));

        //Set include dirs
        if (($includeDirs = $input->getOption('includeDir'))) {
            $compiler->setIncludeDirs($includeDirs);
        }

        //Add namespace prefix if needed
        if ($input->getOption('namespace')) {
            $compiler->setNamespacePrefix($input->getOption('namespace'));
        }

        if ($input->getOption('validate')) {
            $compiler->addValidate();
        }

        $return = $compiler->compile($definitionPath, $input->getOption('server'));

        //Error
        if (!$return) {
            $output->writeln(sprintf('<error>%s</error>', $compiler->getLastOutput()));
        } else {
            $output->writeln(sprintf('<info>%s</info>', $compiler->getLastOutput()));
        }
    }
}
