<?php

/*
 * This file is part of the OverblogThriftBundle package.
 *
 * (c) Overblog <http://github.com/overblog/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Overblog\ThriftBundle\Tests\Functional;

use Overblog\ThriftBundle\Tests\Functional\app\AppKernel;
use Overblog\ThriftBundle\Tests\Thrift\Transport\THttpClient;
use Overblog\ThriftBundle\Tests\ThriftBundleTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Filesystem\Filesystem;

/**
 * TestCase.
 */
abstract class TestCase extends WebTestCase
{
    /**
     * @var AppKernel[]
     */
    private static $kernels = [];

    protected static function getKernelClass()
    {
        require_once __DIR__.'/app/AppKernel.php';

        return 'Overblog\ThriftBundle\Tests\Functional\app\AppKernel';
    }

    /**
     * {@inheritdoc}
     */
    protected static function createKernel(array $options = [])
    {
        if (null === static::$class) {
            static::$class = static::getKernelClass();
        }

        $options['test_case'] = isset($options['test_case']) ? $options['test_case'] : null;

        $env = isset($options['environment']) ? $options['environment'] : 'overblogthriftbundletest'.strtolower($options['test_case']);
        $debug = isset($options['debug']) ? $options['debug'] : true;

        $kernelKey = $options['test_case'] ?: '__default__';
        $kernelKey .= '//'.$env.'//'.var_export($debug, true);

        if (!isset(self::$kernels[$kernelKey])) {
            self::$kernels[$kernelKey] = new static::$class($env, $debug, $options['test_case']);
        }

        return self::$kernels[$kernelKey];
    }

    /**
     * {@inheritdoc}
     */
    public static function setUpBeforeClass()
    {
        $fs = new Filesystem();
        $fs->remove(ThriftBundleTestCase::getTmpDir().'/OverblogThriftBundle/');
    }

    protected static function createClient(array $options = [], array $server = [])
    {
        $client = parent::createClient($options, $server);
        THttpClient::setClient($client);
        static::$kernel->getContainer()->get('thrift.compile_warmer')->compile();

        return $client;
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        static::$kernel = null;
    }
}
