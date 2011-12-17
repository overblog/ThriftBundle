<?php
/**
 *  @generated
 */

namespace Overblog\ThriftBundle\Model\Comment\Processor;

use Thrift\Type\TType;
use Thrift\Type\TMessageType;
use Thrift\Protocol\TProtocol;

class CommentProcessor {
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

  protected function process_getCommentById($seqid, $input, $output) {
    $args = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentGetCommentByIdArgs();
    $args->read($input);
    $input->readMessageEnd();
    $result = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentGetCommentByIdResult();
    try {
      $result->success = $this->handler_->getCommentById($args->id);
    } catch (\Overblog\ThriftBundle\Model\Comment\InvalidValueException $e) {
      $result->e = $e;
    }
    $bin_accel = ($output instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($output, 'getCommentById', TMessageType::REPLY, $result, $seqid, $output->isStrictWrite());
    }
    else
    {
      $output->writeMessageBegin('getCommentById', TMessageType::REPLY, $seqid);
      $result->write($output);
      $output->getTransport()->flush();
    }
  }
  protected function process_getCommentsByIdElement($seqid, $input, $output) {
    $args = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentGetCommentsByIdElementArgs();
    $args->read($input);
    $input->readMessageEnd();
    $result = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentGetCommentsByIdElementResult();
    $result->success = $this->handler_->getCommentsByIdElement($args->id_element, $args->offset, $args->limit, $args->offset_replies, $args->limit_replies, $args->state, $args->orderType, $args->orderAsc);
    $bin_accel = ($output instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($output, 'getCommentsByIdElement', TMessageType::REPLY, $result, $seqid, $output->isStrictWrite());
    }
    else
    {
      $output->writeMessageBegin('getCommentsByIdElement', TMessageType::REPLY, $seqid);
      $result->write($output);
      $output->getTransport()->flush();
    }
  }
  protected function process_getReplies($seqid, $input, $output) {
    $args = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentGetRepliesArgs();
    $args->read($input);
    $input->readMessageEnd();
    $result = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentGetRepliesResult();
    $result->success = $this->handler_->getReplies($args->id);
    $bin_accel = ($output instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($output, 'getReplies', TMessageType::REPLY, $result, $seqid, $output->isStrictWrite());
    }
    else
    {
      $output->writeMessageBegin('getReplies', TMessageType::REPLY, $seqid);
      $result->write($output);
      $output->getTransport()->flush();
    }
  }
  protected function process_createComment($seqid, $input, $output) {
    $args = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentCreateCommentArgs();
    $args->read($input);
    $input->readMessageEnd();
    $result = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentCreateCommentResult();
    $result->success = $this->handler_->createComment($args->comment);
    $bin_accel = ($output instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($output, 'createComment', TMessageType::REPLY, $result, $seqid, $output->isStrictWrite());
    }
    else
    {
      $output->writeMessageBegin('createComment', TMessageType::REPLY, $seqid);
      $result->write($output);
      $output->getTransport()->flush();
    }
  }
  protected function process_createReply($seqid, $input, $output) {
    $args = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentCreateReplyArgs();
    $args->read($input);
    $input->readMessageEnd();
    $result = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentCreateReplyResult();
    $result->success = $this->handler_->createReply($args->comment, $args->id_comment_parent);
    $bin_accel = ($output instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($output, 'createReply', TMessageType::REPLY, $result, $seqid, $output->isStrictWrite());
    }
    else
    {
      $output->writeMessageBegin('createReply', TMessageType::REPLY, $seqid);
      $result->write($output);
      $output->getTransport()->flush();
    }
  }
  protected function process_deleteComment($seqid, $input, $output) {
    $args = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentDeleteCommentArgs();
    $args->read($input);
    $input->readMessageEnd();
    $result = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentDeleteCommentResult();
    $result->success = $this->handler_->deleteComment($args->id);
    $bin_accel = ($output instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($output, 'deleteComment', TMessageType::REPLY, $result, $seqid, $output->isStrictWrite());
    }
    else
    {
      $output->writeMessageBegin('deleteComment', TMessageType::REPLY, $seqid);
      $result->write($output);
      $output->getTransport()->flush();
    }
  }
  protected function process_approveComment($seqid, $input, $output) {
    $args = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentApproveCommentArgs();
    $args->read($input);
    $input->readMessageEnd();
    $result = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentApproveCommentResult();
    $result->success = $this->handler_->approveComment($args->id);
    $bin_accel = ($output instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($output, 'approveComment', TMessageType::REPLY, $result, $seqid, $output->isStrictWrite());
    }
    else
    {
      $output->writeMessageBegin('approveComment', TMessageType::REPLY, $seqid);
      $result->write($output);
      $output->getTransport()->flush();
    }
  }
  protected function process_unapproveComment($seqid, $input, $output) {
    $args = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentUnapproveCommentArgs();
    $args->read($input);
    $input->readMessageEnd();
    $result = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentUnapproveCommentResult();
    $result->success = $this->handler_->unapproveComment($args->id);
    $bin_accel = ($output instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($output, 'unapproveComment', TMessageType::REPLY, $result, $seqid, $output->isStrictWrite());
    }
    else
    {
      $output->writeMessageBegin('unapproveComment', TMessageType::REPLY, $seqid);
      $result->write($output);
      $output->getTransport()->flush();
    }
  }
  protected function process_markCommentAsSpam($seqid, $input, $output) {
    $args = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentMarkCommentAsSpamArgs();
    $args->read($input);
    $input->readMessageEnd();
    $result = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentMarkCommentAsSpamResult();
    $result->success = $this->handler_->markCommentAsSpam($args->id);
    $bin_accel = ($output instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($output, 'markCommentAsSpam', TMessageType::REPLY, $result, $seqid, $output->isStrictWrite());
    }
    else
    {
      $output->writeMessageBegin('markCommentAsSpam', TMessageType::REPLY, $seqid);
      $result->write($output);
      $output->getTransport()->flush();
    }
  }
  protected function process_getCommentsByIdElementParent($seqid, $input, $output) {
    $args = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentGetCommentsByIdElementParentArgs();
    $args->read($input);
    $input->readMessageEnd();
    $result = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentGetCommentsByIdElementParentResult();
    $result->success = $this->handler_->getCommentsByIdElementParent($args->id_element_parent, $args->state);
    $bin_accel = ($output instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($output, 'getCommentsByIdElementParent', TMessageType::REPLY, $result, $seqid, $output->isStrictWrite());
    }
    else
    {
      $output->writeMessageBegin('getCommentsByIdElementParent', TMessageType::REPLY, $seqid);
      $result->write($output);
      $output->getTransport()->flush();
    }
  }
  protected function process_like($seqid, $input, $output) {
    $args = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentLikeArgs();
    $args->read($input);
    $input->readMessageEnd();
    $result = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentLikeResult();
    try {
      $result->success = $this->handler_->like($args->id);
    } catch (\Overblog\ThriftBundle\Model\Comment\InvalidValueException $e) {
      $result->e = $e;
    }
    $bin_accel = ($output instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($output, 'like', TMessageType::REPLY, $result, $seqid, $output->isStrictWrite());
    }
    else
    {
      $output->writeMessageBegin('like', TMessageType::REPLY, $seqid);
      $result->write($output);
      $output->getTransport()->flush();
    }
  }
  protected function process_dislike($seqid, $input, $output) {
    $args = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentDislikeArgs();
    $args->read($input);
    $input->readMessageEnd();
    $result = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentDislikeResult();
    try {
      $result->success = $this->handler_->dislike($args->id);
    } catch (\Overblog\ThriftBundle\Model\Comment\InvalidValueException $e) {
      $result->e = $e;
    }
    $bin_accel = ($output instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($output, 'dislike', TMessageType::REPLY, $result, $seqid, $output->isStrictWrite());
    }
    else
    {
      $output->writeMessageBegin('dislike', TMessageType::REPLY, $seqid);
      $result->write($output);
      $output->getTransport()->flush();
    }
  }
  protected function process_initializePopularity($seqid, $input, $output) {
    $args = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentInitializePopularityArgs();
    $args->read($input);
    $input->readMessageEnd();
    $result = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentInitializePopularityResult();
    try {
      $result->success = $this->handler_->initializePopularity($args->id);
    } catch (\Overblog\ThriftBundle\Model\Comment\InvalidValueException $e) {
      $result->e = $e;
    }
    $bin_accel = ($output instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($output, 'initializePopularity', TMessageType::REPLY, $result, $seqid, $output->isStrictWrite());
    }
    else
    {
      $output->writeMessageBegin('initializePopularity', TMessageType::REPLY, $seqid);
      $result->write($output);
      $output->getTransport()->flush();
    }
  }
}

