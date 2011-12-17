<?php
/**
 *  @generated
 */
namespace Overblog\ThriftBundle\Model\Comment\Definition;

use Thrift\Base\TBase;
use Thrift\Type\TType;
use Thrift\Exception\TException;

class InvalidValueException extends TException {
  static $_TSPEC;

  public $error_code = null;
  public $error_msg = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'error_code',
          'type' => TType::I32,
          ),
        2 => array(
          'var' => 'error_msg',
          'type' => TType::STRING,
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'InvalidValueException';
  }

  public function read($input)
  {
    return $this->_read('InvalidValueException', self::$_TSPEC, $input);
  }
  public function write($output) {
    return $this->_write('InvalidValueException', self::$_TSPEC, $output);
  }
}


