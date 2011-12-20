<?php

namespace Overblog\ThriftBundle\CacheWarmer;

use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerInterface;

/**
 * ThriftModelCacheWarmer to generate Thrift classes
 */
class ThriftModelCacheWarmer implements CacheWarmerInterface
{
    public function warmUp($cacheDir)
    {
        die('THRIFT');
    }

    public function isOptional()
    {
        return false;
    }
}