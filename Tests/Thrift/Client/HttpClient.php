<?php

/*
 * This file is part of the OverblogThriftBundle package.
 *
 * (c) Overblog <http://github.com/overblog/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Overblog\ThriftBundle\Tests\Thrift\Client;

use Overblog\ThriftBundle\Client\HttpClient as BaseHttpClient;

class HttpClient extends BaseHttpClient
{
    protected function getSocketClassName()
    {
        return '\\Overblog\\ThriftBundle\\Tests\\Thrift\\Transport\\THttpClient';
    }
}
