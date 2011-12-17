<?php
/**
 *  @generated
 */
namespace Overblog\ThriftBundle\Model\Comment\Definition;

use Thrift\Base\TBase;
use Thrift\Type\TType;
use Thrift\Exception\TException;

class CommentCreateReplyArgs extends TBase {
  static $_TSPEC;

  public $comment = null;
  public $id_comment_parent = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'comment',
          'type' => TType::STRUCT,
          'class' => '\Overblog\ThriftBundle\Model\Comment\Definition\Comment',
          ),
        2 => array(
          'var' => 'id_comment_parent',
          'type' => TType::I64,
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'CommentCreateReplyArgs';
  }

  public function read($input)
  {
    return $this->_read('CommentCreateReplyArgs', self::$_TSPEC, $input);
  }
  public function write($output) {
    return $this->_write('CommentCreateReplyArgs', self::$_TSPEC, $output);
  }
}


