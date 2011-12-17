<?php
/**
 *  @generated
 */
namespace Overblog\ThriftBundle\Model\Comment\Definition;

use Thrift\Base\TBase;
use Thrift\Type\TType;
use Thrift\Exception\TException;

class CommentCreateCommentArgs extends TBase {
  static $_TSPEC;

  public $comment = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'comment',
          'type' => TType::STRUCT,
          'class' => '\Overblog\ThriftBundle\Model\Comment\Definition\Comment',
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'CommentCreateCommentArgs';
  }

  public function read($input)
  {
    return $this->_read('CommentCreateCommentArgs', self::$_TSPEC, $input);
  }
  public function write($output) {
    return $this->_write('CommentCreateCommentArgs', self::$_TSPEC, $output);
  }
}


