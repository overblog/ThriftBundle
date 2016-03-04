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
     * Included dirs
     * @var string[]
     */
    protected $includeDirs = array();

    /**
     * Base compiler options
     * @var array
     */
    protected $options = array('oop' => null);

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
     * Add a directory to the list of directories searched for include directives
     * @param string[] $includeDirs
     */
    public function setIncludeDirs($includeDirs)
    {
        $this->includeDirs = (array)$includeDirs;
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
     * Generate PHP validator methods
     */
    public function addValidate()
    {
        $this->options['validate'] = null;
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

        // prepare includeDirs
        $includeDirs = '';
        foreach ($this->includeDirs as $includeDir) {
            $includeDirs .= ' -I '. $includeDir;
        }

        //Reset output
        $this->lastOutput = null;

        $cmd = sprintf(
            '%s -r -v --gen php:%s --out %s %s %s 2>&1',
            $this->getExecPath(),
            $this->compileOptions(),
            $this->modelPath,
            $includeDirs,
            $definition
        );

        exec($cmd, $this->lastOutput, $return);

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