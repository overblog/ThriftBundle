<?php

/*
 * This file is part of the OverblogThriftBundle package.
 *
 * (c) Overblog <http://github.com/overblog/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * UNIT TEST.
 *
 * @author Xavier HAUSHERR
 */
namespace Overblog\ThriftBundle\Tests\Compiler;

use Overblog\ThriftBundle\Command\CompileCommand;
use Overblog\ThriftBundle\Tests\Command\AppKernelMock;
use Overblog\ThriftBundle\Tests\ThriftBundleTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

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
