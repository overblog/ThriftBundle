<?php
/**
 *  @generated
 */
namespace Overblog\ThriftBundle\Model\Comment\Definition;

use Thrift\Base\TBase;
use Thrift\Type\TType;
use Thrift\Exception\TException;

class BlogPingArgs extends TBase {
  static $_TSPEC;


  public function __construct() {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        );
    }
  }

  public function getName() {
    return 'BlogPingArgs';
  }

  public function read($input)
  {
    return $this->_read('BlogPingArgs', self::$_TSPEC, $input);
  }
  public function write($output) {
    return $this->_write('BlogPingArgs', self::$_TSPEC, $output);
  }
}


