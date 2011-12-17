<?php
/**
 *  @generated
 */
namespace Overblog\ThriftBundle\Model\Comment\Definition;

use Thrift\Base\TBase;
use Thrift\Type\TType;
use Thrift\Exception\TException;

class CommentGetCommentsByIdElementArgs extends TBase {
  static $_TSPEC;

  public $id_element = null;
  public $offset = null;
  public $limit = null;
  public $offset_replies = null;
  public $limit_replies = null;
  public $state = null;
  public $orderType = null;
  public $orderAsc = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'id_element',
          'type' => TType::I64,
          ),
        2 => array(
          'var' => 'offset',
          'type' => TType::I32,
          ),
        3 => array(
          'var' => 'limit',
          'type' => TType::I32,
          ),
        4 => array(
          'var' => 'offset_replies',
          'type' => TType::I32,
          ),
        5 => array(
          'var' => 'limit_replies',
          'type' => TType::I32,
          ),
        6 => array(
          'var' => 'state',
          'type' => TType::I32,
          ),
        7 => array(
          'var' => 'orderType',
          'type' => TType::STRING,
          ),
        8 => array(
          'var' => 'orderAsc',
          'type' => TType::STRING,
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'CommentGetCommentsByIdElementArgs';
  }

  public function read($input)
  {
    return $this->_read('CommentGetCommentsByIdElementArgs', self::$_TSPEC, $input);
  }
  public function write($output) {
    return $this->_write('CommentGetCommentsByIdElementArgs', self::$_TSPEC, $output);
  }
}


