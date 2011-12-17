<?php
/**
 *  @generated
 */
namespace Overblog\ThriftBundle\Model\Comment\Definition;

use Thrift\Base\TBase;
use Thrift\Type\TType;
use Thrift\Exception\TException;

class CommentDislikeResult extends TBase {
  static $_TSPEC;

  public $success = null;
  public $e = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        0 => array(
          'var' => 'success',
          'type' => TType::BOOL,
          ),
        1 => array(
          'var' => 'e',
          'type' => TType::STRUCT,
          'class' => '\Overblog\ThriftBundle\Model\Comment\Definition\InvalidValueException',
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'CommentDislikeResult';
  }

  public function read($input)
  {
    return $this->_read('CommentDislikeResult', self::$_TSPEC, $input);
  }
  public function write($output) {
    return $this->_write('CommentDislikeResult', self::$_TSPEC, $output);
  }
}


