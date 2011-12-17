<?php
/**
 *  @generated
 */
namespace Overblog\ThriftBundle\Model\Comment\Definition;

use Thrift\Base\TBase;
use Thrift\Type\TType;
use Thrift\Exception\TException;

class BlogPingResult extends TBase {
  static $_TSPEC;


  public function __construct() {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        );
    }
  }

  public function getName() {
    return 'BlogPingResult';
  }

  public function read($input)
  {
    return $this->_read('BlogPingResult', self::$_TSPEC, $input);
  }
  public function write($output) {
    return $this->_write('BlogPingResult', self::$_TSPEC, $output);
  }
}


