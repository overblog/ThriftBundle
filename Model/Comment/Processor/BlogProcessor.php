<?php
/**
 *  @generated
 */

namespace Overblog\ThriftBundle\Model\Comment\Processor;

use Thrift\Type\TType;
use Thrift\Type\TMessageType;
use Thrift\Protocol\TProtocol;

class BlogProcessor {
  protected $handler_ = null;
  public function __construct($handler) {
    $this->handler_ = $handler;
  }

  public function process($input, $output) {
    $rseqid = 0;
    $fname = null;
    $mtype = 0;

    $input->readMessageBegin($fname, $mtype, $rseqid);
    $methodname = 'process_'.$fname;
    if (!method_exists($this, $methodname)) {
      $input->skip(TType::STRUCT);
      $input->readMessageEnd();
      $x = new TApplicationException('Function '.$fname.' not implemented.', TApplicationException::UNKNOWN_METHOD);
      $output->writeMessageBegin($fname, TMessageType::EXCEPTION, $rseqid);
      $x->write($output);
      $output->writeMessageEnd();
      $output->getTransport()->flush();
      return;
    }
    $this->$methodname($rseqid, $input, $output);
    return true;
  }

  protected function process_ping($seqid, $input, $output) {
    $args = new \Overblog\ThriftBundle\Model\Comment\Definition\BlogPingArgs();
    $args->read($input);
    $input->readMessageEnd();
    $result = new \Overblog\ThriftBundle\Model\Comment\Definition\BlogPingResult();
    $this->handler_->ping();
    $bin_accel = ($output instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($output, 'ping', TMessageType::REPLY, $result, $seqid, $output->isStrictWrite());
    }
    else
    {
      $output->writeMessageBegin('ping', TMessageType::REPLY, $seqid);
      $result->write($output);
      $output->getTransport()->flush();
    }
  }
}

