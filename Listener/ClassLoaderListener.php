<?php

namespace Overblog\ThriftBundle\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\ClassLoader\MapClassLoader;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Overblog\ThriftBundle\CacheWarmer\ThriftCompileCacheWarmer;

/**
 * Inject Class Loader
 *
 * @author xavier
 */
class ClassLoaderListener
{
    /**
     * SF Cache Dir
     *
     * @var string
     */
    protected $cacheDir;

    /**
     * Inject Env
     *
     * @param string $cacheDir
     */
    public function __construct($cacheDir)
    {
        $this->cacheDir = $cacheDir;
    }

    /**
     * Start Event of controller
     *
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        // Loader must be loaded only in master Request
        if($event->getRequestType() !== HttpKernelInterface::MASTER_REQUEST)
        {
            return;
        }

        self::registerClassLoader($this->cacheDir);
    }

    /**
     * Start Event of Command
     *
     * @param ConsoleCommandEvent $event
     */
    public function onConsoleCommand(ConsoleCommandEvent $event)
    {
        self::registerClassLoader($this->cacheDir);
    }

    /**
     * Register Class Loader
     *
     * @param string $cacheDir
     */
    public static function registerClassLoader($cacheDir)
    {
        $path = sprintf('%s/%s/classes.map', $cacheDir, ThriftCompileCacheWarmer::CACHE_SUFFIX);

        $classMap = require $path;
        $l = new MapClassLoader($classMap);
        $l->register();
    }
}
