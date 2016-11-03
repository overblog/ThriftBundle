<?php

/*
 * This file is part of the OverblogThriftBundle package.
 *
 * (c) Overblog <http://github.com/overblog/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Overblog\ThriftBundle\Tests\Functional\Handler;

class DownloadHandler
{
    public static $counter = 0;

    public function count()
    {
        return static::$counter;
    }

    public static function hit()
    {
        ++static::$counter;
    }
}
