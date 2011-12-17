<?php
/**
 *  @generated
 */
namespace Overblog\ThriftBundle\Model\Comment\Definition;

use Thrift\Base\TBase;
use Thrift\Type\TType;
use Thrift\Exception\TException;

class CommentInitializePopularityArgs extends TBase {
  static $_TSPEC;

  public $id = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'id',
          'type' => TType::I64,
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'CommentInitializePopularityArgs';
  }

  public function read($input)
  {
    return $this->_read('CommentInitializePopularityArgs', self::$_TSPEC, $input);
  }
  public function write($output) {
    return $this->_write('CommentInitializePopularityArgs', self::$_TSPEC, $output);
  }
}


