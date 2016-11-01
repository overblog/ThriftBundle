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

class ClientMetadata
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $service;

    /**
     * @var HostMetadata[]
     */
    private $hosts = [];

    /**
     * @var int
     */
    private $cache;

    public function __construct(array $options)
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            'type' => 'http',
            'service' => null,
            'hosts' => [
                'host' => null,
                'port' => 80,
                'recvTimeout' => null,
                'sendTimeout' => null,
                'httpTimeoutSecs' => null,
            ],
            'cache' => 0,
        ]);
        $resolvedOptions = $resolver->resolve($options);

        foreach ($resolvedOptions as $key => $value) {
            if ('hosts' === $key) {
                $this->hosts = array_map(function ($host) {
                    return HostMetadata::create($host);
                }, $value);
                continue;
            }
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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @return HostMetadata[]
     */
    public function getHosts()
    {
        return $this->hosts;
    }

    /**
     * @return int
     */
    public function getCache()
    {
        return $this->cache;
    }
}
