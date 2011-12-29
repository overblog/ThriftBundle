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
     * Constructor
     *
     * @param ContainerInterface $container
     */

    public function __construct(ContainerInterface $container, ThriftFactory $factory)
    {
        $this->_container = $container;
        $this->factory = $factory;
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
     * @param string $service
     * @param string $classe
     * @param mixed $param
     * @return mixed
     */
    public function getInstance($service, $classe, $param = null)
    {
        return $this->factory->getInstance($service, $classe, $param);
    }
}