<?php
namespace Overblog\ThriftBundle\Exception;

/**
 * Configuration Exception
 * @author Xavier HAUSHERR
 */

class ConfigurationException extends \Exception {

    /**
     * Create exception and set message
     * @param string $message
     */
    public function __construct($message)
    {
        parent::__construct($message, null, null);
    }

    /**
     * Return the message
     * @return String
     */
    public function __toString()
    {
        return $this->message;
    }

}