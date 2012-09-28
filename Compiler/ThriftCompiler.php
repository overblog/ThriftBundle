<?php

namespace Overblog\ThriftBundle\Compiler;

use Overblog\ThriftBundle\Exception\ConfigurationException;

/**
 * Thrift compiler
 * @author Xavier HAUSHERR
 */

class ThriftCompiler
{
    /**
     * Thrift Executable name
     * @var string
     */
    protected $thriftExec = 'thrift';

    /**
     * Thrift Executable path
     * @var string
     */
    protected $thriftPath = '/usr/local/bin/';

    /**
     * Model Path
     * @var string
     */
    protected $modelPath;

    /**
     * Base compiler options
     * @var array
     */
    protected $options = array('sf2' => null);

    /**
     * Last compiler output
     * @var string
     */
    protected $lastOutput;

    /**
     * Return Thrift path
     * @return string
     */
    protected function getExecPath()
    {
        return $this->thriftPath . $this->thriftExec;
    }

    /**
     * Set exec path
     * @param string $path
     * @return bool
     */
    public function setExecPath($path)
    {
        if('/' !== substr($path, -1))
        {
            $path .= '/';
        }

        $this->thriftPath = $path;

        return $this->checkExec();
    }

    /**
     * Check if Thrift exec is installed
     * @throws \Overblog\ThriftBundle\Exception\ConfigurationException
     * @return boolean
     */
    protected function checkExec()
    {
        if(!file_exists($this->getExecPath()))
        {
            throw new ConfigurationException('Unable to find Thrift executable');
        }

        return true;
    }

    /**
     * Set model path and create it if needed
     * @param string $path
     */
    public function setModelPath($path)
    {
        if(!is_null($path) && !file_exists($path))
        {
            mkdir($path);
        }

        $this->modelPath = $path;
    }

    /**
     * Set namespace prefix
     * @param string $namespace
     */
    public function setNamespacePrefix($namespace)
    {
        $this->options['nsglobal'] = escapeshellarg($namespace);
    }

    /**
     * Compile server files too (processor)
     */
    protected function addServerCompile()
    {
        if(!isset($this->options['server']))
        {
            $this->options['server'] = null;
        }
    }

    /**
     * Compile the thrift options
     * @return string
     */
    protected function compileOptions()
    {
        $return = array();

        foreach($this->options as $option => $value)
        {
            $return[] = $option . (!empty($value) ? '=' . $value : '');
        }

        return implode(',', $return);
    }

    /**
     * Compile the Thrift definition
     * @param string $definition
     * @param boolean $serverCompile
     * @throws \Overblog\ThriftBundle\Exception\ConfigurationException
     * @return boolean
     */
    public function compile($definition, $serverCompile = false)
    {
        // Check if definition file exists
        if(!file_exists($definition))
        {
            throw new ConfigurationException(sprintf('Unable to find Thrift definition at path "%s"', $definition));
        }

        if(true === $serverCompile)
        {
            $this->addServerCompile();
        }

        //Reset output
        $this->lastOutput = null;

        exec(sprintf('%s -r -v --gen php:%s --out %s %s 2>&1',
            $this->getExecPath(),
            $this->compileOptions(),
            $this->modelPath,
            $definition
        ), $this->lastOutput, $return);

        return (0 === $return) ? true : false;
    }

    /**
     * Return the last compiler output
     * @return string
     */
    public function getLastOutput()
    {
        return $this->lastOutput;
    }
}