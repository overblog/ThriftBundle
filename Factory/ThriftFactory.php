<?php

namespace Overblog\ThriftBundle\Factory;

use Overblog\ThriftBundle\ClassLoader\ThriftLoader;
use Overblog\ThriftBundle\ClassLoader\ApcThriftLoader;

/**
 * Thrift factory
 *
 * @author Xavier HAUSHERR
 */

class ThriftFactory
{
    protected $services;
    protected $disableApc;

    /**
     * Inject dependencies
     * @param array $services
     * @param boolean $disableApc
     */
    public function __construct(Array $services, $disableApc = true)
    {
        $this->services = $services;
        $this->disableApc = $disableApc;
    }

    /**
     * Initialize loader
     * @param array $namespaces
     */
    public function initLoader(Array $namespaces)
    {
        if(false === $this->disableApc)
        {
            $loader = new ApcThriftLoader('thrift');
        }
        else
        {
            $loader = new ThriftLoader();
        }

        $loader->registerNamespaces($namespaces);
        $loader->register();
    }

    /**
     * Init class with factory. It assumes the loader if allready loaded
     * @param string $className
     * @param array $args
     * @return mixed
     */
    public function initExtensionInstance($className, Array $args)
    {
        $ext = new \ReflectionClass($className);
        return $ext->newInstanceArgs($args);
    }

    /**
     * Return an instance of a Thrift Model Class
     *
     * @note => We keep this method for compatibily reason and to be user
     *          that auloader is correctly start
     *
     * @param string $classe
     * @param mixed $param
     * @return Object
     */
    public function getInstance($classe, $param = null)
    {
        if(is_null($param))
        {
            return new $classe();
        }
        else
        {
            return new $classe($param);
        }
    }

    /**
     * Return a processor instance
     * @param string $service
     * @param mixed $handler
     * @return Object
     */
    public function getProcessorInstance($service, $handler)
    {
        $classe = sprintf('%s\%sProcessor', $this->services[$service]['namespace'], $this->services[$service]['className']);

        return new $classe($handler);
    }

    /**
     * Return a client instance
     * @param string $service
     * @param Thrift\Protocol\TProtocol $protocol
     * @return Object
     */
    public function getClientInstance($service, $protocol)
    {
        $classe = sprintf('%s\%sClient', $this->services[$service]['namespace'], $this->services[$service]['className']);

        return new $classe($protocol);
    }
}