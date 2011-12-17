<?php
/**
 *  @generated
 */
namespace Overblog\ThriftBundle\Model\Comment\Definition;

use Thrift\Base\TBase;
use Thrift\Type\TType;
use Thrift\Exception\TException;

class CommentCreateReplyResult extends TBase {
  static $_TSPEC;

  public $success = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        0 => array(
          'var' => 'success',
          'type' => TType::I64,
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'CommentCreateReplyResult';
  }

  public function read($input)
  {
    return $this->_read('CommentCreateReplyResult', self::$_TSPEC, $input);
  }
  public function write($output) {
    return $this->_write('CommentCreateReplyResult', self::$_TSPEC, $output);
  }
}


