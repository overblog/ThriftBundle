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
use Overblog\ThriftBundle\Factory\ThriftFactory;

/**
 * Symfony extension for Thrift Extension
 *
 * @category   Bundle
 * @package    InternalApi
 * @subpackage Base extension
 * @author     Vincent Bouzeran <vincent.bouzeran@elao.com>
 * @author     Yannick Le Guédart <yannick@overblog.com>
 */

class BaseExtension
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
     * Service name
     * @var string
     */
    protected $service;

    /**
     * Constructor
     *
     * @param ContainerInterface $container
     */

    public function __construct(ContainerInterface $container, ThriftFactory $factory, $service)
    {
        $this->_container = $container;
        $this->factory = $factory;
        $this->service = $service;
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
     * Get instance of Thrift Model classes
     * @param string $classe
     * @param mixed $param
     * @return mixed
     */
    public function getInstance($classe, $param = null)
    {
        return $this->factory->getInstance($this->service, $classe, $param);
    }
}