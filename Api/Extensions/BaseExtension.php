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
     * Get instance of Thrift Model classes
     * @param string $classe
     * @param mixed $param
     * @return mixed
     */
    public function getInstance($classe, $param = null)
    {
        return $this->factory->getInstance($this->getServiceName(), $classe, $param);
    }

    /**
     * Return the Code Exception class name to use
     * @return string
     */
    protected function getCodeExceptionClassName()
    {
        return 'Overblog\ThriftBundle\Exception\Code';
    }

    /**
     * Generate Invalid value Exception
     * @param string $errorKey
     * @return InvalidValueException
     */
    protected function generateException($errorKey)
    {
        $codeClass = $this->getCodeExceptionClassName();
        $code = constant($codeClass . '::' . $errorKey);

        return $this->getInstance($this->getExceptionClassName(), array(
            'code' => $code,
            'message' => $codeClass::$_errorMessage[$code]
        ));
    }

    /**
     * Return the Thrift Service Name to use
     */
    abstract protected function getServiceName();

    /**
     * Return the Thrift Exception class name to use
     */
    abstract protected function getExceptionClassName();
}