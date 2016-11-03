<?php

/*
 * This file is part of the OverblogThriftBundle package.
 *
 * (c) Overblog <http://github.com/overblog/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Overblog\ThriftBundle\Client;

/**
 * ThriftTestClient is used to replace Thrift Client by a PhpUnit Mocked version.
 *
 * @author Xavier HAUSHERR <xavier.hausherr@ebuzzing.com>
 */
class ThriftTestClient extends ThriftClient
{
    /**
     * {@inheritdoc}
     */
    public function getClient()
    {
        if (is_null($this->client)) {
            $className = $this->factory->getClientClassName($this->name);

            // Init Mock
            $phpunit = new ThriftTestClientPhpunit();

            $this->client = $phpunit->getMockBuilder($className)
                                    ->disableOriginalConstructor()
                                    ->getMock();
        }

        return $this->client;
    }
}
