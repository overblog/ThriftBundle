<?php

/*
 * This file is part of the OverblogThriftBundle package.
 *
 * (c) Overblog <http://github.com/overblog/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Overblog\ThriftBundle\Exception;

/**
 * Configuration Exception.
 *
 * @author Xavier HAUSHERR
 */
class ConfigurationException extends \Exception
{
    /**
     * Create exception and set message.
     *
     * @param string $message
     */
    public function __construct($message)
    {
        parent::__construct($message, null, null);
    }

    /**
     * Return the message.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->message;
    }
}
