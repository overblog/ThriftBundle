<?php

/*
 * This file is part of the OverblogThriftBundle package.
 *
 * (c) Overblog <http://github.com/overblog/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Overblog\ThriftBundle\Metadata;

use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceMetadata
{
    /**
     * @var string
     */
    private $definition;

    /**
     * @var string
     */
    private $className;

    /**
     * @var string
     */
    private $namespace;

    /**
     * @var string
     */
    private $definitionPath;

    /**
     * @var string
     */
    private $transport;

    /**
     * @var bool
     */
    private $server;

    /**
     * @var string
     */
    private $protocol;

    /**
     * @var bool
     */
    private $buffered_transport;

    /**
     * @var bool
     */
    private $validate;

    /**
     * @var string[]
     */
    private $includeDirs;

    public function __construct(array $options)
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            'definition' => null,
            'className' => null,
            'namespace' => null,
            'definitionPath' => null,
            'transport' => null,
            'server' => false,
            'protocol' => null,
            'buffered_transport' => true,
            'validate' => false,
            'includeDirs' => [],
        ]);
        $resolvedOptions = $resolver->resolve($options);

        foreach ($resolvedOptions as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public static function create(array $options)
    {
        return new static($options);
    }

    /**
     * @return string
     */
    public function getDefinition()
    {
        return $this->definition;
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @return string
     */
    public function getDefinitionPath()
    {
        return $this->definitionPath;
    }

    /**
     * @return string
     */
    public function getTransport()
    {
        return $this->transport;
    }

    /**
     * @return bool
     */
    public function isServer()
    {
        return $this->server;
    }

    /**
     * @return string
     */
    public function getProtocol()
    {
        return $this->protocol;
    }

    /**
     * @return bool
     */
    public function isBufferedTransport()
    {
        return $this->buffered_transport;
    }

    /**
     * @return bool
     */
    public function isValidate()
    {
        return $this->validate;
    }

    /**
     * @return \String[]
     */
    public function getIncludeDirs()
    {
        return $this->includeDirs;
    }
}
