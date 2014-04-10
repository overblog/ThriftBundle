<?php

namespace Overblog\ThriftBundle\Client;

use Overblog\ThriftBundle\Client\ThriftClient;
use Overblog\ThriftBundle\Client\ThriftTestClientPhpunit;

/**
 * ThriftTestClient is used to replace Thrift Client by a PhpUnit Mocked version
 *
 * @author Xavier HAUSHERR <xavier.hausherr@ebuzzing.com>
 */
class ThriftTestClient extends ThriftClient
{
    /**
     * @inheritdoc
     */
    public function getClient()
    {
        if(is_null($this->client))
        {
            $className = sprintf(
                    '%s\%sClient',
                    $this->config['service_config']['namespace'],
                    $this->config['service_config']['className']
                );

            // Init Mock
            $phpunit = new ThriftTestClientPhpunit();

            $this->client = $phpunit->getMockBuilder($className)
                                    ->disableOriginalConstructor()
                                    ->getMock();
        }

        return $this->client;
    }
}
