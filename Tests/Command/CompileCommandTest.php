<?php
/**
 * UNIT TEST
 *
 * @author Xavier HAUSHERR
 */
namespace Overblog\ThriftBundle\Tests\Compiler;

use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Bundle\FrameworkBundle\Console\Application;

use Overblog\ThriftBundle\Tests\ThriftBundleTestCase;
use Overblog\ThriftBundle\Tests\Command\AppKernelMock;
use Overblog\ThriftBundle\Compiler\ThriftCompiler;

use Overblog\ThriftBundle\Command\CompileCommand;

class CompileCommandTest extends ThriftBundleTestCase
{
    protected $application;

    protected function setUp()
    {
//        parent::setUp();
//
//        $kernel = new AppKernelMock('test', false);
//        $this->application = new Application($kernel);
//        $this->application->add(new CompileCommand());
    }

    public function testExecute()
    {
//        $command = $this->application->find('thrift:compile');
//        $commandTester = new CommandTester($command);
//        $commandTester->execute(array(
//            'command' => $command->getName(),
//            'bundleName' => 'OverblogThriftBundle',
//            'definition' => 'Test',
//        ), array(
//            'server' => true
//        ));
//
//        var_dump($commandTester->getDisplay());
//
//        $this->assertRegExp('/.../', $commandTester->getDisplay());
    }
}