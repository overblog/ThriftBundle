<?php

namespace Overblog\ThriftBundle\Tests;

class ThriftBundleTestCase extends \PHPUnit_Framework_TestCase
{
    protected $modelPath;
    protected $definitionPath;
    protected $namespace = 'Overblog\ThriftBundle\Tests';

    protected function setUp()
    {
        $this->modelPath = __DIR__ . '/ThriftModel';
        $this->definitionPath = __DIR__ . '/ThriftDefinition/Test.thrift';
    }

    protected function tearDown()
    {
        exec(sprintf('rm -rf %s 2>&1 > /dev/null', $this->modelPath));
    }
}
