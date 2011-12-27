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

class BaseExtension
{
    /**
     * Injected SF2 container
     *
     * @var type
     */

    protected $_container;

    /**
     * Constructor
     *
     * @param ContainerInterface $container
     */

    public function __construct(ContainerInterface $container)
    {
        $this->_container = $container;
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
}