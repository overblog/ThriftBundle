<?php
/**
 *  @generated
 */
namespace Overblog\ThriftBundle\Model\Comment\Definition;

use Thrift\Base\TBase;
use Thrift\Type\TType;
use Thrift\Exception\TException;

class CommentGetCommentsByIdElementParentArgs extends TBase {
  static $_TSPEC;

  public $id_element_parent = null;
  public $state = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'id_element_parent',
          'type' => TType::I64,
          ),
        2 => array(
          'var' => 'state',
          'type' => TType::I32,
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'CommentGetCommentsByIdElementParentArgs';
  }

  public function read($input)
  {
    return $this->_read('CommentGetCommentsByIdElementParentArgs', self::$_TSPEC, $input);
  }
  public function write($output) {
    return $this->_write('CommentGetCommentsByIdElementParentArgs', self::$_TSPEC, $output);
  }
}


