<?php

/*
 * This file is part of the OverblogThriftBundle package.
 *
 * (c) Overblog <http://github.com/overblog/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Overblog\ThriftBundle\Thrift\Transport;

use Thrift\Exception\TException;
use Thrift\Factory\TStringFuncFactory;
use Thrift\Transport\TPhpStream as BaseTPhpStream;
use Thrift\Transport\TTransport;

class TPhpStream extends TTransport
{
    const MODE_R = BaseTPhpStream::MODE_R;
    const MODE_W = BaseTPhpStream::MODE_W;

    private $inStream_ = null;

    private $outStream_ = null;

    private $read_ = false;

    private $write_ = false;

    public function __construct($mode, $inStream = null)
    {
        $this->read_ = $mode & self::MODE_R;
        $this->write_ = $mode & self::MODE_W;
        if ($this->read_) {
            if (!is_resource($inStream)) {
                throw new TException('inStream should be a resource.');
            }
            $this->inStream_ = $inStream;
        }
    }

    public function open()
    {
        if ($this->write_) {
            $this->outStream_ = @fopen('php://output', 'w');
            if (!is_resource($this->outStream_)) {
                throw new TException('TPhpStream: Could not open php://output');
            }
        }
    }

    public function close()
    {
        if ($this->read_) {
            @fclose($this->inStream_);
            $this->inStream_ = null;
        }
        if ($this->write_) {
            @fclose($this->outStream_);
            $this->outStream_ = null;
        }
    }

    public function isOpen()
    {
        return
            (!$this->read_ || is_resource($this->inStream_)) &&
            (!$this->write_ || is_resource($this->outStream_));
    }

    public function read($len)
    {
        $data = @fread($this->inStream_, $len);
        if ($data === false || $data === '') {
            throw new TException('TPhpStream: Could not read '.$len.' bytes');
        }

        return $data;
    }

    public function write($buf)
    {
        while (TStringFuncFactory::create()->strlen($buf) > 0) {
            $got = @fwrite($this->outStream_, $buf);
            if ($got === 0 || $got === false) {
                throw new TException('TPhpStream: Could not write '.TStringFuncFactory::create()->strlen($buf).' bytes');
            }
            $buf = TStringFuncFactory::create()->substr($buf, $got);
        }
    }

    public function flush()
    {
        @fflush($this->outStream_);
    }
}
