<?php
/**
 *  @generated
 */

namespace Overblog\ThriftBundle\Model\Comment\Client;

interface CommentInterface {
  public function getCommentById($id);
  public function getCommentsByIdElement($id_element, $offset, $limit, $offset_replies, $limit_replies, $state, $orderType, $orderAsc);
  public function getReplies($id);
  public function createComment($comment);
  public function createReply($comment, $id_comment_parent);
  public function deleteComment($id);
  public function approveComment($id);
  public function unapproveComment($id);
  public function markCommentAsSpam($id);
  public function getCommentsByIdElementParent($id_element_parent, $state);
  public function like($id);
  public function dislike($id);
  public function initializePopularity($id);
}


