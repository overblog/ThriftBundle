<?php

/*
 * This file is part of the OverblogThriftBundle package.
 *
 * (c) Overblog <http://github.com/overblog/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Overblog\ThriftBundle\Tests\Functional\Controller;

use Overblog\ThriftBundle\Cache\ClientCacheProxyManager;
use Overblog\ThriftBundle\Tests\Functional\Handler\DownloadHandler;
use Overblog\ThriftBundle\Tests\Functional\TestCase;

class ClientCacheProxyManagerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        if (!ClientCacheProxyManager::isRequirementsFulfilled()) {
            $this->markTestSkipped('Client cache proxy manager not fulfilled.');
        }
    }

    public function testDownloadCount()
    {
        $client = static::createClient();
        $downloadThriftClient = $client->getContainer()->get('thrift.client.download');

        DownloadHandler::hit();
        $count = $downloadThriftClient->getClient()->count();
        $this->assertEquals(DownloadHandler::$counter, $count, 'retrieve without cache');

        DownloadHandler::hit();
        $this->assertEquals($count, $downloadThriftClient->getClient()->count(), 'using cache');

        $this->assertEquals(DownloadHandler::$counter, $downloadThriftClient->getClient(false)->count(), 'bypass cache');
    }
}
