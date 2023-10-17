<?php 

namespace App\Service;

use App\Entity\Comment;

class CommentCheck 
{
    public function checkCommentLength(Comment $comment) {
        if (strlen($comment->getContent()) < 10) {
            return false;
        } else {
            return true;
        }
    }
}