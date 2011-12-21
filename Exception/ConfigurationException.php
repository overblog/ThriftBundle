<?php
namespace Overblog\ThriftBundle\Exception;

class ConfigurationException extends \Exception {

    public function __construct($message)
    {
        parent::__construct($message, null, null);
    }

    public function __toString()
    {
        return $this->message;
    }

}