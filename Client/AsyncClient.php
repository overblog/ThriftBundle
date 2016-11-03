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

use GuzzleHttp\Promise\Promise;
use GuzzleHttp\Promise\PromiseInterface;
use Overblog\ThriftBundle\Metadata\Metadata;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Process\PhpProcess;
use Symfony\Component\Process\Process;

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

    /**
     * @param $clientName
     * @param $method
     * @param array $params
     *
     * @return PromiseInterface
     */
    public function send($clientName, $method, array $params = [])
    {
        if (!static::isRequirementsFulFilled()) {
            throw new \RuntimeException('To use thrift async client, the package "guzzlehttp/promises" is required.');
        }

        $client = $this->metadata->getClient($clientName);

        $handler = function () use ($clientName, $method, $params) {
            $process = new PhpProcess($this->getScript($clientName, $method, $params));
            $process->start();

            return static::finish($process);
        };

        try {
            $promise = \GuzzleHttp\Promise\promise_for($handler());
        } catch (\Exception $e) {
            $promise = \GuzzleHttp\Promise\rejection_for($e);
        }

        return $promise;
    }

    private static function finish(Process $process)
    {
        if ($process->isTerminated()) {
            if ($process->isSuccessful()) {
                $payload = unserialize($process->getOutput());

                if (isset($payload['state'])) {
                    switch ($payload['state']) {
                        case PromiseInterface::FULFILLED:
                            return $payload['value'];

                        case PromiseInterface::REJECTED:
                            if (isset($payload['reason']['exception'])) {
                                throw $payload['reason']['exception'];
                            }
                            break;
                    }
                }

                throw new \RuntimeException('Could not found state in payload.');
            }

            throw new \RuntimeException('Unknown error.');
        }

        $promise = new Promise(
            function () use (&$promise, $process, &$onComplete) {
                $process->wait();

                try {
                    $data = static::finish($process);
                    $promise->resolve($data);
                } catch (\Exception $e) {
                    $promise->reject($e);
                }

                return $promise;
            },
            function () use (&$promise, $process) {
                $process->stop(0, SIGINT);
            }
        );

        return $promise;
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
        $payloadSuccessful = PromiseInterface::FULFILLED;
        $payloadFailure = PromiseInterface::REJECTED;

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
        'value' => call_user_func_array([\$thriftClient, '$method'], unserialize('$serializeParams'))
    ];
} catch(\\Exception \$e) {
    \$payload = [
        'state' => '$payloadFailure',
        'reason' => ['exception' => \$e],
    ];
}

echo serialize(\$payload);
EOF;

        return $code;
    }

    public static function isRequirementsFulFilled()
    {
        return class_exists('GuzzleHttp\\Promise\\Promise');
    }
}
