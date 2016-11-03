<?php

/*
 * This file is part of the OverblogThriftBundle package.
 *
 * (c) Overblog <http://github.com/overblog/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Overblog\ThriftBundle\Promise;

use Symfony\Component\Process\Process;

class Promise
{
    const PENDING = 'pending';
    const FULFILLED = 'fulfilled';
    const REJECTED = 'rejected';

    private $process;

    private $status;

    private $callbacks = [];

    private $payload;

    public function __construct(Process $process)
    {
        $this->status = static::PENDING;

        $process->setTimeout(null);
        $process->start();

        $this->process = $process;
    }

    public function getProcess()
    {
        return $this->process;
    }

    public function isFulfilled()
    {
        $this->getProcess()->isTerminated();
    }

    public function payload()
    {
        return $this->payload;
    }

    public function cancel()
    {
        $this->getProcess()->stop(0, SIGINT);
    }

    public function then(callable $onFulfilled = null, callable $onRejected = null)
    {
        if (null !== $onFulfilled) {
            $this->callbacks[static::FULFILLED] = $onFulfilled;
        }
        if (null !== $onRejected) {
            $this->callbacks[static::REJECTED] = $onRejected;
        }
    }
}
