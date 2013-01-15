<?php
namespace Overblog\ThriftBundle\Tests\Compiler;

use Overblog\ThriftBundle\Tests\ThriftBundleTestCase;
use Overblog\ThriftBundle\Compiler\ThriftCompiler;

/**
 * UNIT TEST
 *
 * @author Xavier HAUSHERR
 */
class CompilerTest extends ThriftBundleTestCase
{
    public function testCompile()
    {
        $compiler = new ThriftCompiler();

        $this->assertTrue($compiler->setExecPath('/usr/local/bin', 'Work without /'));

        $this->assertTrue($compiler->setExecPath('/usr/local/bin/', 'Work with /'));

        $compiler->setModelPath($this->modelPath);

        // Add namespace prefix
        $compiler->setNamespacePrefix($this->namespace);

        // First compile without server
        $this->assertTrue($compiler->compile($this->definitionPath), 'Return no error');

        // Check if the return is correct
        $this->assertEquals($compiler->getLastOutput(),
            array(
                sprintf('Scanning %s for includes', realpath($this->definitionPath)),
                sprintf('Parsing %s for types', realpath($this->definitionPath)),
                sprintf('Program: %s', realpath($this->definitionPath)),
                sprintf('Generating "php:oop,nsglobal=%s"', $this->namespace)
            )
        );

        // Now compile with server
        $this->assertTrue($compiler->compile($this->definitionPath, true), 'Return no error');

        // Check if the return is correct
        $this->assertEquals($compiler->getLastOutput(),
            array(
                sprintf('Scanning %s for includes', realpath($this->definitionPath)),
                sprintf('Parsing %s for types', realpath($this->definitionPath)),
                sprintf('Program: %s', realpath($this->definitionPath)),
                sprintf('Generating "php:oop,nsglobal=%s,server"', $this->namespace)
            )
        );

        // Unknow definition
        $this->setExpectedException('Overblog\ThriftBundle\Exception\ConfigurationException',
			sprintf('Unable to find Thrift definition at path "%s"', $this->definitionPath . 'UNKNOWN')
		);

        $compiler->compile($this->definitionPath . 'UNKNOWN', true);
    }

    public function testExec()
    {
        $compiler = new ThriftCompiler();

        // Bad exec path
        $this->setExpectedException('Overblog\ThriftBundle\Exception\ConfigurationException',
			'Unable to find Thrift executable'
		);

        $compiler->setExecPath(__DIR__);
    }
}
