<?php

namespace Overblog\ThriftBundle\Tests;

use Overblog\ThriftBundle\Compiler\ThriftCompiler;
use Symfony\Component\ClassLoader\MapClassLoader;
use Symfony\Component\ClassLoader\ClassMapGenerator;

class ThriftBundleTestCase extends \PHPUnit_Framework_TestCase
{
    protected $modelPath;
    protected $definitionPath;
    protected $namespace = 'Overblog\ThriftBundle\Tests';
    protected $compiler;

    protected function setUp()
    {
        $this->modelPath = __DIR__ . '/thrift';
        $this->definitionPath = __DIR__ . '/ThriftDefinition/Test.thrift';
    }

    protected function compile()
    {
        //Build cache
        $this->compiler = new ThriftCompiler();
        $this->compiler->setModelPath($this->modelPath);
        $this->compiler->compile($this->definitionPath, true);

        // Init Loader
        $l = new MapClassLoader(ClassMapGenerator::createMap($this->modelPath));
        $l->register();
    }

    protected function tearDown()
    {
        exec(sprintf('rm -rf %s 2>&1 > /dev/null', $this->modelPath));
    }

    protected function onNotSuccessfulTest($e)
    {
        exec(sprintf('rm -rf %s 2>&1 > /dev/null', $this->modelPath));

        parent::onNotSuccessfulTest($e);
    }
}