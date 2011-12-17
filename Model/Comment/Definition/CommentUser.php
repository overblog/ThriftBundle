<?php
/**
 *  @generated
 */
namespace Overblog\ThriftBundle\Model\Comment\Definition;

use Thrift\Base\TBase;
use Thrift\Type\TType;
use Thrift\Exception\TException;

class CommentUser extends TBase {
  static $_TSPEC;

  public $token = null;
  public $origin = null;
  public $avatar = null;
  public $name = null;
  public $email = null;
  public $url = null;
  public $ip = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'token',
          'type' => TType::STRING,
          ),
        2 => array(
          'var' => 'origin',
          'type' => TType::STRING,
          ),
        3 => array(
          'var' => 'avatar',
          'type' => TType::STRING,
          ),
        4 => array(
          'var' => 'name',
          'type' => TType::STRING,
          ),
        5 => array(
          'var' => 'email',
          'type' => TType::STRING,
          ),
        6 => array(
          'var' => 'url',
          'type' => TType::STRING,
          ),
        7 => array(
          'var' => 'ip',
          'type' => TType::I32,
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'CommentUser';
  }

  public function read($input)
  {
    return $this->_read('CommentUser', self::$_TSPEC, $input);
  }
  public function write($output) {
    return $this->_write('CommentUser', self::$_TSPEC, $output);
  }
}


