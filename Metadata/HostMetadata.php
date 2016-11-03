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

class HostMetadata
{
    /**
     * @var string
     */
    private $host;

    /**
     * @var int
     */
    private $port;

    /**
     * @var int
     */
    private $recvTimeout;

    /**
     * @var int
     */
    private $sendTimeout;

    /**
     * @var int
     */
    private $httpTimeoutSecs;

    public function __construct(array $options)
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            'host' => null,
            'port' => 80,
            'recvTimeout' => null,
            'sendTimeout' => null,
            'httpTimeoutSecs' => null,
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
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @return int
     */
    public function getRecvTimeout()
    {
        return $this->recvTimeout;
    }

    /**
     * @return int
     */
    public function getSendTimeout()
    {
        return $this->sendTimeout;
    }

    /**
     * @return int
     */
    public function getHttpTimeoutSecs()
    {
        return $this->httpTimeoutSecs;
    }
}
