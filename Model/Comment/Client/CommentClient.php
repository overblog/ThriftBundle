<?php
/**
 *  @generated
 */

namespace Overblog\ThriftBundle\Model\Comment\Client;

use Thrift\Type\TMessageType;
use Thrift\Protocol\TProtocol;
use Thrift\Exception\TApplicationException;

class CommentClient implements \Overblog\ThriftBundle\Model\Comment\Client\CommentInterface {
  protected $input_ = null;
  protected $output_ = null;

  protected $seqid_ = 0;

  public function __construct($input, $output=null) {
    $this->input_ = $input;
    $this->output_ = $output ? $output : $input;
  }

  public function getCommentById($id)
  {
    $this->send_getCommentById($id);
    return $this->recv_getCommentById();
  }

  public function send_getCommentById($id)
  {
    $args = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentGetCommentByIdArgs();
    $args->id = $id;
    $bin_accel = ($this->output_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($this->output_, 'getCommentById', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
    }
    else
    {
      $this->output_->writeMessageBegin('getCommentById', TMessageType::CALL, $this->seqid_);
      $args->write($this->output_);
      $this->output_->writeMessageEnd();
      $this->output_->getTransport()->flush();
    }
  }

  public function recv_getCommentById()
  {
    $bin_accel = ($this->input_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_read_binary');
    if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\Overblog\ThriftBundle\Model\Comment\Definition\CommentGetCommentByIdResult', $this->input_->isStrictRead());
    else
    {
      $rseqid = 0;
      $fname = null;
      $mtype = 0;

      $this->input_->readMessageBegin($fname, $mtype, $rseqid);
      if ($mtype == TMessageType::EXCEPTION) {
        $x = new TApplicationException();
        $x->read($this->input_);
        $this->input_->readMessageEnd();
        throw $x;
      }
      $result = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentGetCommentByIdResult();
      $result->read($this->input_);
      $this->input_->readMessageEnd();
    }
    if ($result->success !== null) {
      return $result->success;
    }
    if ($result->e !== null) {
      throw $result->e;
    }
    throw new Exception("getCommentById failed: unknown result");
  }

  public function getCommentsByIdElement($id_element, $offset, $limit, $offset_replies, $limit_replies, $state, $orderType, $orderAsc)
  {
    $this->send_getCommentsByIdElement($id_element, $offset, $limit, $offset_replies, $limit_replies, $state, $orderType, $orderAsc);
    return $this->recv_getCommentsByIdElement();
  }

  public function send_getCommentsByIdElement($id_element, $offset, $limit, $offset_replies, $limit_replies, $state, $orderType, $orderAsc)
  {
    $args = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentGetCommentsByIdElementArgs();
    $args->id_element = $id_element;
    $args->offset = $offset;
    $args->limit = $limit;
    $args->offset_replies = $offset_replies;
    $args->limit_replies = $limit_replies;
    $args->state = $state;
    $args->orderType = $orderType;
    $args->orderAsc = $orderAsc;
    $bin_accel = ($this->output_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($this->output_, 'getCommentsByIdElement', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
    }
    else
    {
      $this->output_->writeMessageBegin('getCommentsByIdElement', TMessageType::CALL, $this->seqid_);
      $args->write($this->output_);
      $this->output_->writeMessageEnd();
      $this->output_->getTransport()->flush();
    }
  }

  public function recv_getCommentsByIdElement()
  {
    $bin_accel = ($this->input_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_read_binary');
    if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\Overblog\ThriftBundle\Model\Comment\Definition\CommentGetCommentsByIdElementResult', $this->input_->isStrictRead());
    else
    {
      $rseqid = 0;
      $fname = null;
      $mtype = 0;

      $this->input_->readMessageBegin($fname, $mtype, $rseqid);
      if ($mtype == TMessageType::EXCEPTION) {
        $x = new TApplicationException();
        $x->read($this->input_);
        $this->input_->readMessageEnd();
        throw $x;
      }
      $result = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentGetCommentsByIdElementResult();
      $result->read($this->input_);
      $this->input_->readMessageEnd();
    }
    if ($result->success !== null) {
      return $result->success;
    }
    throw new Exception("getCommentsByIdElement failed: unknown result");
  }

  public function getReplies($id)
  {
    $this->send_getReplies($id);
    return $this->recv_getReplies();
  }

  public function send_getReplies($id)
  {
    $args = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentGetRepliesArgs();
    $args->id = $id;
    $bin_accel = ($this->output_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($this->output_, 'getReplies', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
    }
    else
    {
      $this->output_->writeMessageBegin('getReplies', TMessageType::CALL, $this->seqid_);
      $args->write($this->output_);
      $this->output_->writeMessageEnd();
      $this->output_->getTransport()->flush();
    }
  }

  public function recv_getReplies()
  {
    $bin_accel = ($this->input_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_read_binary');
    if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\Overblog\ThriftBundle\Model\Comment\Definition\CommentGetRepliesResult', $this->input_->isStrictRead());
    else
    {
      $rseqid = 0;
      $fname = null;
      $mtype = 0;

      $this->input_->readMessageBegin($fname, $mtype, $rseqid);
      if ($mtype == TMessageType::EXCEPTION) {
        $x = new TApplicationException();
        $x->read($this->input_);
        $this->input_->readMessageEnd();
        throw $x;
      }
      $result = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentGetRepliesResult();
      $result->read($this->input_);
      $this->input_->readMessageEnd();
    }
    if ($result->success !== null) {
      return $result->success;
    }
    throw new Exception("getReplies failed: unknown result");
  }

  public function createComment($comment)
  {
    $this->send_createComment($comment);
    return $this->recv_createComment();
  }

  public function send_createComment($comment)
  {
    $args = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentCreateCommentArgs();
    $args->comment = $comment;
    $bin_accel = ($this->output_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($this->output_, 'createComment', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
    }
    else
    {
      $this->output_->writeMessageBegin('createComment', TMessageType::CALL, $this->seqid_);
      $args->write($this->output_);
      $this->output_->writeMessageEnd();
      $this->output_->getTransport()->flush();
    }
  }

  public function recv_createComment()
  {
    $bin_accel = ($this->input_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_read_binary');
    if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\Overblog\ThriftBundle\Model\Comment\Definition\CommentCreateCommentResult', $this->input_->isStrictRead());
    else
    {
      $rseqid = 0;
      $fname = null;
      $mtype = 0;

      $this->input_->readMessageBegin($fname, $mtype, $rseqid);
      if ($mtype == TMessageType::EXCEPTION) {
        $x = new TApplicationException();
        $x->read($this->input_);
        $this->input_->readMessageEnd();
        throw $x;
      }
      $result = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentCreateCommentResult();
      $result->read($this->input_);
      $this->input_->readMessageEnd();
    }
    if ($result->success !== null) {
      return $result->success;
    }
    throw new Exception("createComment failed: unknown result");
  }

  public function createReply($comment, $id_comment_parent)
  {
    $this->send_createReply($comment, $id_comment_parent);
    return $this->recv_createReply();
  }

  public function send_createReply($comment, $id_comment_parent)
  {
    $args = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentCreateReplyArgs();
    $args->comment = $comment;
    $args->id_comment_parent = $id_comment_parent;
    $bin_accel = ($this->output_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($this->output_, 'createReply', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
    }
    else
    {
      $this->output_->writeMessageBegin('createReply', TMessageType::CALL, $this->seqid_);
      $args->write($this->output_);
      $this->output_->writeMessageEnd();
      $this->output_->getTransport()->flush();
    }
  }

  public function recv_createReply()
  {
    $bin_accel = ($this->input_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_read_binary');
    if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\Overblog\ThriftBundle\Model\Comment\Definition\CommentCreateReplyResult', $this->input_->isStrictRead());
    else
    {
      $rseqid = 0;
      $fname = null;
      $mtype = 0;

      $this->input_->readMessageBegin($fname, $mtype, $rseqid);
      if ($mtype == TMessageType::EXCEPTION) {
        $x = new TApplicationException();
        $x->read($this->input_);
        $this->input_->readMessageEnd();
        throw $x;
      }
      $result = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentCreateReplyResult();
      $result->read($this->input_);
      $this->input_->readMessageEnd();
    }
    if ($result->success !== null) {
      return $result->success;
    }
    throw new Exception("createReply failed: unknown result");
  }

  public function deleteComment($id)
  {
    $this->send_deleteComment($id);
    return $this->recv_deleteComment();
  }

  public function send_deleteComment($id)
  {
    $args = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentDeleteCommentArgs();
    $args->id = $id;
    $bin_accel = ($this->output_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($this->output_, 'deleteComment', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
    }
    else
    {
      $this->output_->writeMessageBegin('deleteComment', TMessageType::CALL, $this->seqid_);
      $args->write($this->output_);
      $this->output_->writeMessageEnd();
      $this->output_->getTransport()->flush();
    }
  }

  public function recv_deleteComment()
  {
    $bin_accel = ($this->input_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_read_binary');
    if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\Overblog\ThriftBundle\Model\Comment\Definition\CommentDeleteCommentResult', $this->input_->isStrictRead());
    else
    {
      $rseqid = 0;
      $fname = null;
      $mtype = 0;

      $this->input_->readMessageBegin($fname, $mtype, $rseqid);
      if ($mtype == TMessageType::EXCEPTION) {
        $x = new TApplicationException();
        $x->read($this->input_);
        $this->input_->readMessageEnd();
        throw $x;
      }
      $result = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentDeleteCommentResult();
      $result->read($this->input_);
      $this->input_->readMessageEnd();
    }
    if ($result->success !== null) {
      return $result->success;
    }
    throw new Exception("deleteComment failed: unknown result");
  }

  public function approveComment($id)
  {
    $this->send_approveComment($id);
    return $this->recv_approveComment();
  }

  public function send_approveComment($id)
  {
    $args = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentApproveCommentArgs();
    $args->id = $id;
    $bin_accel = ($this->output_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($this->output_, 'approveComment', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
    }
    else
    {
      $this->output_->writeMessageBegin('approveComment', TMessageType::CALL, $this->seqid_);
      $args->write($this->output_);
      $this->output_->writeMessageEnd();
      $this->output_->getTransport()->flush();
    }
  }

  public function recv_approveComment()
  {
    $bin_accel = ($this->input_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_read_binary');
    if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\Overblog\ThriftBundle\Model\Comment\Definition\CommentApproveCommentResult', $this->input_->isStrictRead());
    else
    {
      $rseqid = 0;
      $fname = null;
      $mtype = 0;

      $this->input_->readMessageBegin($fname, $mtype, $rseqid);
      if ($mtype == TMessageType::EXCEPTION) {
        $x = new TApplicationException();
        $x->read($this->input_);
        $this->input_->readMessageEnd();
        throw $x;
      }
      $result = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentApproveCommentResult();
      $result->read($this->input_);
      $this->input_->readMessageEnd();
    }
    if ($result->success !== null) {
      return $result->success;
    }
    throw new Exception("approveComment failed: unknown result");
  }

  public function unapproveComment($id)
  {
    $this->send_unapproveComment($id);
    return $this->recv_unapproveComment();
  }

  public function send_unapproveComment($id)
  {
    $args = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentUnapproveCommentArgs();
    $args->id = $id;
    $bin_accel = ($this->output_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($this->output_, 'unapproveComment', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
    }
    else
    {
      $this->output_->writeMessageBegin('unapproveComment', TMessageType::CALL, $this->seqid_);
      $args->write($this->output_);
      $this->output_->writeMessageEnd();
      $this->output_->getTransport()->flush();
    }
  }

  public function recv_unapproveComment()
  {
    $bin_accel = ($this->input_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_read_binary');
    if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\Overblog\ThriftBundle\Model\Comment\Definition\CommentUnapproveCommentResult', $this->input_->isStrictRead());
    else
    {
      $rseqid = 0;
      $fname = null;
      $mtype = 0;

      $this->input_->readMessageBegin($fname, $mtype, $rseqid);
      if ($mtype == TMessageType::EXCEPTION) {
        $x = new TApplicationException();
        $x->read($this->input_);
        $this->input_->readMessageEnd();
        throw $x;
      }
      $result = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentUnapproveCommentResult();
      $result->read($this->input_);
      $this->input_->readMessageEnd();
    }
    if ($result->success !== null) {
      return $result->success;
    }
    throw new Exception("unapproveComment failed: unknown result");
  }

  public function markCommentAsSpam($id)
  {
    $this->send_markCommentAsSpam($id);
    return $this->recv_markCommentAsSpam();
  }

  public function send_markCommentAsSpam($id)
  {
    $args = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentMarkCommentAsSpamArgs();
    $args->id = $id;
    $bin_accel = ($this->output_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($this->output_, 'markCommentAsSpam', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
    }
    else
    {
      $this->output_->writeMessageBegin('markCommentAsSpam', TMessageType::CALL, $this->seqid_);
      $args->write($this->output_);
      $this->output_->writeMessageEnd();
      $this->output_->getTransport()->flush();
    }
  }

  public function recv_markCommentAsSpam()
  {
    $bin_accel = ($this->input_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_read_binary');
    if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\Overblog\ThriftBundle\Model\Comment\Definition\CommentMarkCommentAsSpamResult', $this->input_->isStrictRead());
    else
    {
      $rseqid = 0;
      $fname = null;
      $mtype = 0;

      $this->input_->readMessageBegin($fname, $mtype, $rseqid);
      if ($mtype == TMessageType::EXCEPTION) {
        $x = new TApplicationException();
        $x->read($this->input_);
        $this->input_->readMessageEnd();
        throw $x;
      }
      $result = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentMarkCommentAsSpamResult();
      $result->read($this->input_);
      $this->input_->readMessageEnd();
    }
    if ($result->success !== null) {
      return $result->success;
    }
    throw new Exception("markCommentAsSpam failed: unknown result");
  }

  public function getCommentsByIdElementParent($id_element_parent, $state)
  {
    $this->send_getCommentsByIdElementParent($id_element_parent, $state);
    return $this->recv_getCommentsByIdElementParent();
  }

  public function send_getCommentsByIdElementParent($id_element_parent, $state)
  {
    $args = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentGetCommentsByIdElementParentArgs();
    $args->id_element_parent = $id_element_parent;
    $args->state = $state;
    $bin_accel = ($this->output_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($this->output_, 'getCommentsByIdElementParent', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
    }
    else
    {
      $this->output_->writeMessageBegin('getCommentsByIdElementParent', TMessageType::CALL, $this->seqid_);
      $args->write($this->output_);
      $this->output_->writeMessageEnd();
      $this->output_->getTransport()->flush();
    }
  }

  public function recv_getCommentsByIdElementParent()
  {
    $bin_accel = ($this->input_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_read_binary');
    if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\Overblog\ThriftBundle\Model\Comment\Definition\CommentGetCommentsByIdElementParentResult', $this->input_->isStrictRead());
    else
    {
      $rseqid = 0;
      $fname = null;
      $mtype = 0;

      $this->input_->readMessageBegin($fname, $mtype, $rseqid);
      if ($mtype == TMessageType::EXCEPTION) {
        $x = new TApplicationException();
        $x->read($this->input_);
        $this->input_->readMessageEnd();
        throw $x;
      }
      $result = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentGetCommentsByIdElementParentResult();
      $result->read($this->input_);
      $this->input_->readMessageEnd();
    }
    if ($result->success !== null) {
      return $result->success;
    }
    throw new Exception("getCommentsByIdElementParent failed: unknown result");
  }

  public function like($id)
  {
    $this->send_like($id);
    return $this->recv_like();
  }

  public function send_like($id)
  {
    $args = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentLikeArgs();
    $args->id = $id;
    $bin_accel = ($this->output_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($this->output_, 'like', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
    }
    else
    {
      $this->output_->writeMessageBegin('like', TMessageType::CALL, $this->seqid_);
      $args->write($this->output_);
      $this->output_->writeMessageEnd();
      $this->output_->getTransport()->flush();
    }
  }

  public function recv_like()
  {
    $bin_accel = ($this->input_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_read_binary');
    if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\Overblog\ThriftBundle\Model\Comment\Definition\CommentLikeResult', $this->input_->isStrictRead());
    else
    {
      $rseqid = 0;
      $fname = null;
      $mtype = 0;

      $this->input_->readMessageBegin($fname, $mtype, $rseqid);
      if ($mtype == TMessageType::EXCEPTION) {
        $x = new TApplicationException();
        $x->read($this->input_);
        $this->input_->readMessageEnd();
        throw $x;
      }
      $result = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentLikeResult();
      $result->read($this->input_);
      $this->input_->readMessageEnd();
    }
    if ($result->success !== null) {
      return $result->success;
    }
    if ($result->e !== null) {
      throw $result->e;
    }
    throw new Exception("like failed: unknown result");
  }

  public function dislike($id)
  {
    $this->send_dislike($id);
    return $this->recv_dislike();
  }

  public function send_dislike($id)
  {
    $args = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentDislikeArgs();
    $args->id = $id;
    $bin_accel = ($this->output_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($this->output_, 'dislike', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
    }
    else
    {
      $this->output_->writeMessageBegin('dislike', TMessageType::CALL, $this->seqid_);
      $args->write($this->output_);
      $this->output_->writeMessageEnd();
      $this->output_->getTransport()->flush();
    }
  }

  public function recv_dislike()
  {
    $bin_accel = ($this->input_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_read_binary');
    if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\Overblog\ThriftBundle\Model\Comment\Definition\CommentDislikeResult', $this->input_->isStrictRead());
    else
    {
      $rseqid = 0;
      $fname = null;
      $mtype = 0;

      $this->input_->readMessageBegin($fname, $mtype, $rseqid);
      if ($mtype == TMessageType::EXCEPTION) {
        $x = new TApplicationException();
        $x->read($this->input_);
        $this->input_->readMessageEnd();
        throw $x;
      }
      $result = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentDislikeResult();
      $result->read($this->input_);
      $this->input_->readMessageEnd();
    }
    if ($result->success !== null) {
      return $result->success;
    }
    if ($result->e !== null) {
      throw $result->e;
    }
    throw new Exception("dislike failed: unknown result");
  }

  public function initializePopularity($id)
  {
    $this->send_initializePopularity($id);
    return $this->recv_initializePopularity();
  }

  public function send_initializePopularity($id)
  {
    $args = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentInitializePopularityArgs();
    $args->id = $id;
    $bin_accel = ($this->output_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($this->output_, 'initializePopularity', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
    }
    else
    {
      $this->output_->writeMessageBegin('initializePopularity', TMessageType::CALL, $this->seqid_);
      $args->write($this->output_);
      $this->output_->writeMessageEnd();
      $this->output_->getTransport()->flush();
    }
  }

  public function recv_initializePopularity()
  {
    $bin_accel = ($this->input_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_read_binary');
    if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\Overblog\ThriftBundle\Model\Comment\Definition\CommentInitializePopularityResult', $this->input_->isStrictRead());
    else
    {
      $rseqid = 0;
      $fname = null;
      $mtype = 0;

      $this->input_->readMessageBegin($fname, $mtype, $rseqid);
      if ($mtype == TMessageType::EXCEPTION) {
        $x = new TApplicationException();
        $x->read($this->input_);
        $this->input_->readMessageEnd();
        throw $x;
      }
      $result = new \Overblog\ThriftBundle\Model\Comment\Definition\CommentInitializePopularityResult();
      $result->read($this->input_);
      $this->input_->readMessageEnd();
    }
    if ($result->success !== null) {
      return $result->success;
    }
    if ($result->e !== null) {
      throw $result->e;
    }
    throw new Exception("initializePopularity failed: unknown result");
  }

}


