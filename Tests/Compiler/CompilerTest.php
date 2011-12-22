<?php
/**
 * UNIT TEST
 *
 * @author Xavier HAUSHERR
 */
namespace Overblog\ThriftBundle\Tests\Compiler;

use Overblog\ThriftBundle\Compiler\ThriftCompiler;

class CompilerTest extends \PHPUnit_Framework_TestCase
{
    protected $modelPath;
    protected $definitionPath;
    protected $namespace = 'Overblog\ThriftBundle\Tests';

    protected function setUp()
    {
        $this->modelPath = __DIR__ . '/../ThriftModel';
        $this->definitionPath = __DIR__ . '/../ThriftDefinition/Test.thrift';
    }

    public function testCompile()
    {
        $compiler = new ThriftCompiler();

        $compiler->setModelPath($this->modelPath);

        $this->assertFalse($compiler->emptyModelPath('Test'), 'Return false because Definition directory does not exists');

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
                sprintf('Generating "php:oop,namespace,autoload,nsglobal=%s"', $this->namespace)
            )
        );

        // Empty old model
        $this->assertTrue($compiler->emptyModelPath('Test'));

        // Now compile with server
        $this->assertTrue($compiler->compile($this->definitionPath, true), 'Return no error');

        // Check if the return is correct
        $this->assertEquals($compiler->getLastOutput(),
            array(
                sprintf('Scanning %s for includes', realpath($this->definitionPath)),
                sprintf('Parsing %s for types', realpath($this->definitionPath)),
                sprintf('Program: %s', realpath($this->definitionPath)),
                sprintf('Generating "php:oop,namespace,autoload,nsglobal=%s,server"', $this->namespace)
            )
        );
    }

    protected function tearDown()
    {
        exec(sprintf('rm -rf %s 2>&1 > /dev/null', $this->modelPath));
    }
}