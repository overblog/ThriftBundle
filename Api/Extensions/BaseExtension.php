<?php
/**
 * Symfony extension for Thrift Extension
 *
 * @category  Bundle
 * @package   InternalApi
 * @author    Vincent Bouzeran <vincent.bouzeran@elao.com>
 * @author    Yannick Le Guédart <yannick@overblog.com>
 * @copyright 2011 Overblog
 */

namespace Overblog\ThriftBundle\Api\Extensions;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Symfony extension for Thrift Extension
 *
 * @category   Bundle
 * @package    InternalApi
 * @subpackage Base extension
 * @author     Vincent Bouzeran <vincent.bouzeran@elao.com>
 * @author     Yannick Le Guédart <yannick@overblog.com>
 */

abstract class BaseExtension
{
    /**
     * Injected SF2 container
     *
     * @var type
     */
    protected $_container;

    /**
     * Thrift Factory
     * @var type
     */
    protected $factory;

    /**
     * Constructor
     *
     * @param ContainerInterface $container
     */

    public function __construct(ContainerInterface $container)
    {
        $this->_container = $container;
        $this->factory = $container->get('thrift.factory');
    }

    /**
     * Returns a service from the injected container
     *
     * @param string $service
     *
     * @return mixed
     */

    public function get($service)
    {
        return $this->_container->get($service);
    }

    /**
     * Set a service to the injected container
     *
     * @param string $id,       The service id
     * @param mixed $service,   The service
     */

    public function set($id, $service)
    {
        $this->_container->set($id, $service);
    }

    /**
     * Returns a parameter from the injected container
     *
     * @param string $name
     *
     * @return mixed
     */
    public function getParameter($name)
    {
        return $this->_container->getParameter($name);
    }

    /**
     * Get instance of Thrift Model classes
     * @param string $classe
     * @param mixed $param
     * @return mixed
     */
    public function getInstance($classe, $param = null)
    {
        return $this->factory->getInstance($classe, $param);
    }
}
