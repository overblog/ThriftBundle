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

use Overblog\ThriftBundle\Metadata\Metadata;
use Overblog\ThriftBundle\Promise\Promise;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Process\PhpProcess;

class AsyncClient
{
    /**
     * @var KernelInterface
     */
    private $kernel;

    /**
     * Config handler.
     *
     * @var Metadata
     */
    private $metadata;

    public function __construct(Metadata $metadata, KernelInterface $kernel)
    {
        $this->metadata = $metadata;
        $this->kernel = $kernel;
    }

    public function send($clientName, $method, array $params = [])
    {
        $client = $this->metadata->getClient($clientName);

        $process = new PhpProcess($this->getScript($clientName, $method, $params));

        return new Promise($process);
    }

    private function getScript($clientName, $method, array $params = [])
    {
        $kernel = str_replace("'", "\\'", serialize($this->kernel));
        $serializeParams = str_replace("'", "\\'", serialize($params));

        $kernelReflection = new \ReflectionObject($this->kernel);
        $autoloader = dirname($kernelReflection->getFileName()).'/autoload.php';
        if (is_file($autoloader)) {
            $autoloader = str_replace("'", "\\'", $autoloader);
        } else {
            $autoloader = '';
        }
        $path = str_replace("'", "\\'", $kernelReflection->getFileName());
        $errorReporting = error_reporting();
        $clientServiceID = ThriftClient::getServiceClientID($clientName);
        $payloadSuccessful = Promise::FULFILLED;
        $payloadFailure = Promise::REJECTED;

        $code = <<<EOF
<?php

use Overblog\\ThriftBundle\\Listener\\ClassLoaderListener;

error_reporting($errorReporting);

if ('$autoloader') {
    require_once '$autoloader';
}
require_once '$path';

\$kernel = unserialize('$kernel');
\$kernel->boot();
\$container = \$kernel->getContainer();

ClassLoaderListener::registerClassLoader(\$container->getParameter('thrift.cache_dir'));

\$thriftClient = \$container->get('$clientServiceID')->getClient();

try {
    \$payload = [
        'state' => '$payloadSuccessful',
        'payload' => call_user_func_array([\$thriftClient, '$method'], unserialize('$serializeParams'))
    ];
} catch(\\Exception \$e) {
    \$payload = [
        'state' => '$payloadFailure',
        'exception' => \$e,
    ];
}

echo serialize(\$payload);
EOF;

        return $code;
    }
}
