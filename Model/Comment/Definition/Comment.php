<?php
/**
 *  @generated
 */
namespace Overblog\ThriftBundle\Model\Comment\Definition;

use Thrift\Base\TBase;
use Thrift\Type\TType;
use Thrift\Exception\TException;

class Comment extends TBase {
  static $_TSPEC;

  public $id = 0;
  public $id_element = 0;
  public $id_element_parent = 0;
  public $comment = null;
  public $date = null;
  public $state = null;
  public $user = null;
  public $like_count = 0;
  public $dislike_count = 0;
  public $popularity = 0;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'id',
          'type' => TType::I64,
          ),
        2 => array(
          'var' => 'id_element',
          'type' => TType::I64,
          ),
        3 => array(
          'var' => 'id_element_parent',
          'type' => TType::I64,
          ),
        4 => array(
          'var' => 'comment',
          'type' => TType::STRING,
          ),
        5 => array(
          'var' => 'date',
          'type' => TType::I32,
          ),
        6 => array(
          'var' => 'state',
          'type' => TType::I32,
          ),
        7 => array(
          'var' => 'user',
          'type' => TType::STRUCT,
          'class' => '\Overblog\ThriftBundle\Model\Comment\Definition\CommentUser',
          ),
        8 => array(
          'var' => 'like_count',
          'type' => TType::I32,
          ),
        9 => array(
          'var' => 'dislike_count',
          'type' => TType::I32,
          ),
        10 => array(
          'var' => 'popularity',
          'type' => TType::I32,
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'Comment';
  }

  public function read($input)
  {
    return $this->_read('Comment', self::$_TSPEC, $input);
  }
  public function write($output) {
    return $this->_write('Comment', self::$_TSPEC, $output);
  }
}


