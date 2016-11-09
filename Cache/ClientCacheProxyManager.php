<?php

/*
 * This file is part of the OverblogThriftBundle package.
 *
 * (c) Overblog <http://github.com/overblog/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Overblog\ThriftBundle\Cache;

use ProxyManager\Configuration;
use ProxyManager\Factory\AccessInterceptorValueHolderFactory as ProxyFactory;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class ClientCacheProxyManager
{
    const METHOD_SEND_PREFIX = 'send_';
    const METHOD_RECEIVE_PREFIX = 'recv_';
    const PROPERTY_USE_CACHE = '___use_cache___';

    /**
     * @var AdapterInterface
     */
    private $cacheAdapter;

    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @var string
     */
    private $proxyCacheDir;

    /**
     * @var array
     */
    private $clientServicesMethods = [];

    public function __construct($proxyCacheDir, AdapterInterface $cacheAdapter = null)
    {
        $this->cacheAdapter = $cacheAdapter;
        if ($cacheAdapter) {
            $this->proxyCacheDir = $proxyCacheDir;
            $this->configuration = new Configuration();
            $this->configuration->setProxiesTargetDir($proxyCacheDir);
            $this->configuration->setProxiesNamespace(__NAMESPACE__);
        }
    }

    public function mkProxyCacheDirIfNeeded()
    {
        if (!is_dir($this->proxyCacheDir)) {
            mkdir($this->proxyCacheDir, 0755, true);
        }
    }

    public function getCacheAdapter()
    {
        return $this->cacheAdapter;
    }

    public static function generateCacheKey($client, $method, $params)
    {
        // generate a cache key based on the function name and arguments
        $pieces = array_merge([get_class($client).'::'.$method], array_map('serialize', $params));
        $cachedKey = base64_encode(implode('|', $pieces));

        return $cachedKey;
    }

    public function getClientCacheProxy($client, $cacheExpiresAfter = 0)
    {
        if (!$this->getCacheAdapter()) {
            return $client;
        }

        $this->mkProxyCacheDirIfNeeded();

        spl_autoload_register($this->configuration->getProxyAutoloader());
        $factory = new ProxyFactory($this->configuration);

        $clientProxy = $factory->createProxy($client);

        $prefixInterceptor = function ($proxy, $client, $method, $params, &$returnEarly) {
            if (!$this->isClientUsingCache($client)) {
                return;
            }

            return $this->retrieveCacheItem($client, $method, $params, $returnEarly);
        };

        $suffixInterceptor = function ($proxy, $client, $method, $params, $returnValue) use ($cacheExpiresAfter) {
            if (!$this->isClientUsingCache($client)) {
                return;
            }
            $this->saveCacheItemIfNeeded($client, $method, $params, $returnValue, $cacheExpiresAfter);
        };

        foreach ($this->getClientServicesMethods($client) as $method) {
            $clientProxy->setMethodPrefixInterceptor($method, $prefixInterceptor);
            $clientProxy->setMethodsuffixInterceptor($method, $suffixInterceptor);
        }

        return $clientProxy;
    }

    public function clearCache()
    {
        if ($this->getCacheAdapter()) {
            return;
        }
        $this->getCacheAdapter()->clear();
    }

    public static function isRequirementsFulfilled()
    {
        return
            class_exists('ProxyManager\\Factory\\AccessInterceptorValueHolderFactory') &&
            class_exists('Symfony\\Component\\Cache\\Adapter\\FilesystemAdapter');
    }

    private function isClientUsingCache($client)
    {
        return isset($client->{self::PROPERTY_USE_CACHE}) && true === $client->{self::PROPERTY_USE_CACHE};
    }

    private function getClientServicesMethods($client)
    {
        $class = get_class($client);
        if (!array_key_exists($class, $this->clientServicesMethods)) {
            $this->clientServicesMethods[$class] = array_filter(get_class_methods($client), function ($method) {
                return strpos($method, static::METHOD_SEND_PREFIX) !== 0 && strpos($method, static::METHOD_RECEIVE_PREFIX) !== 0 && '__construct' !== $method;
            });
        }

        return $this->clientServicesMethods[$class];
    }

    private function retrieveCacheItem($client, $method, $params, &$returnEarly)
    {
        $cacheKey = static::generateCacheKey($client, $method, $params);
        $item = $this->getCacheAdapter()->getItem($cacheKey);
        if ($item->isHit()) {
            $returnEarly = true;

            return $item->get();
        }
    }

    private function saveCacheItemIfNeeded($client, $method, $params, $returnValue, $expiresAfter = 0)
    {
        $cacheKey = static::generateCacheKey($client, $method, $params);
        $item = $this->getCacheAdapter()->getItem($cacheKey);
        // save only if item cached
        if (!$item->isHit()) {
            $item->set($returnValue)->expiresAfter($expiresAfter);
            $this->getCacheAdapter()->save($item);
        }
    }
}
