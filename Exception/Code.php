<?php

namespace Overblog\ThriftBundle\Exception;

class Code
{
    const WRONG_PARAMETER = 1001;
    const WRONG_TYPE_PARAMETER = 1002;

    static public $_errorMessage = array(
        self::WRONG_TYPE_PARAMETER => 'Wrong Type Parameter',
        self::WRONG_PARAMETER => 'Wrong  Parameter'
    );

}