<?php
/**
 *  @generated
 */
namespace Overblog\ThriftBundle\Model\Comment\Definition;

use Thrift\Base\TBase;
use Thrift\Type\TType;
use Thrift\Exception\TException;

class CommentGetCommentsByIdElementParentResult extends TBase {
  static $_TSPEC;

  public $success = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        0 => array(
          'var' => 'success',
          'type' => TType::LST,
          'etype' => TType::STRUCT,
          'elem' => array(
            'type' => TType::STRUCT,
            'class' => '\Overblog\ThriftBundle\Model\Comment\Definition\Comment',
            ),
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'CommentGetCommentsByIdElementParentResult';
  }

  public function read($input)
  {
    return $this->_read('CommentGetCommentsByIdElementParentResult', self::$_TSPEC, $input);
  }
  public function write($output) {
    return $this->_write('CommentGetCommentsByIdElementParentResult', self::$_TSPEC, $output);
  }
}


