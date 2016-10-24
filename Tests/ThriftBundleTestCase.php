<?php

/*
 * This file is part of the OverblogThriftBundle package.
 *
 * (c) Overblog <http://github.com/overblog/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Overblog\ThriftBundle\Tests;

use Overblog\ThriftBundle\Compiler\ThriftCompiler;
use Symfony\Component\ClassLoader\ClassMapGenerator;
use Symfony\Component\ClassLoader\MapClassLoader;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class ThriftBundleTestCase extends \PHPUnit_Framework_TestCase
{
    protected $modelPath;
    protected $definitionPath;
    protected $namespace = 'Overblog\ThriftBundle\Tests';
    protected $compiler;

    protected function setUp()
    {
        $this->modelPath = __DIR__.'/thrift';
        $this->definitionPath = __DIR__.'/ThriftDefinition/Test.thrift';
    }

    protected function compile()
    {
        //Build cache
        $this->compiler = new ThriftCompiler();
        $this->compiler->setModelPath($this->modelPath);
        if (!$this->compiler->compile($this->definitionPath, true)) {
            throw new ProcessFailedException($this->compiler->getLastCompileProcess());
        }

        // Init Loader
        $l = new MapClassLoader(ClassMapGenerator::createMap($this->modelPath));
        $l->register();
    }

    protected function tearDown()
    {
        $this->removeModelPath();
    }

    protected function onNotSuccessfulTest($e)
    {
        $this->removeModelPath();

        parent::onNotSuccessfulTest($e);
    }

    protected function removeModelPath()
    {
        $process = new Process(sprintf('rm -rf %s 2>&1 > /dev/null', $this->modelPath));
        $process->setTimeout(null);
        $process->run();
    }
}
