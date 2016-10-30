<?php

/*
 * This file is part of the OverblogThriftBundle package.
 *
 * (c) Overblog <http://github.com/overblog/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Overblog\ThriftBundle\Tests\Thrift\Transport;

use Symfony\Bundle\FrameworkBundle\Client;
use Thrift\Exception\TTransportException;
use Thrift\Factory\TStringFuncFactory;
use Thrift\Transport\THttpClient as BaseTHttpClient;

class THttpClient extends BaseTHttpClient
{
    /**
     * @var Client
     */
    private static $client;

    public static function setClient(Client $client)
    {
        self::$client = $client;
    }

    /**
     * @return Client
     */
    public static function getClient()
    {
        return self::$client;
    }

    /**
     * Opens and sends the actual request over the HTTP connection.
     *
     * @throws TTransportException if a writing error occurs
     */
    public function flush()
    {
        // God, PHP really has some esoteric ways of doing simple things.
        $host = $this->host_.($this->port_ != 80 ? ':'.$this->port_ : '');
        ob_start();
        static::getClient()->request(
            'POST',
            $this->scheme_.'://'.$host.$this->uri_,
            [],
            [],
            array_merge(
                [
                    'HTTP_USER_AGENT' => 'PHP/THttpClient',
                    'HTTP_ACCEPT' => 'application/x-thrift',
                    'CONTENT_TYPE' => 'application/x-thrift',
                    'CONTENT_LENGTH' => TStringFuncFactory::create()->strlen($this->buf_),
                ],
                $this->headers_
            ),
            $this->buf_
        );
        $content = ob_get_clean();

        $this->handle_ = fopen('php://temp', 'r+');
        fwrite($this->handle_, $content);
        rewind($this->handle_);

        $this->buf_ = '';

        if (empty($content)) {
            $error = sprintf('THttpClient: Could not connect to %s%s', $host, $this->uri_);
            throw new TTransportException($error, TTransportException::NOT_OPEN);
        }
    }
}
