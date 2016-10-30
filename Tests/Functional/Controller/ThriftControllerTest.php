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

use Overblog\ThriftBundle\Tests\Functional\TestCase;

class ThriftControllerTest extends TestCase
{
    public function testCall()
    {
        $client = static::createClient();
        $testThriftClient = $client->getContainer()->get('thrift.client.alive');

        $this->assertTrue($testThriftClient->getClient()->ping());
    }
}
