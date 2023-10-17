<?php

namespace App\Tests;

use App\Service\CommentCheck;
use App\Entity\Comment;
use PHPUnit\Framework\TestCase;

class CommentCheckTest extends TestCase
{

    protected $comment;
    protected function setUp(): void
    {
        $this->comment = new Comment();
    }

    public function testCommentShort() {

        $service = new CommentCheck();

        $this->comment->setContent('1');

        $result = $service->checkCommentLength($this->comment);

        $this->assertFalse($result);
    }

    public function testCommentLongEnough() {
            
            $service = new CommentCheck();
    
            $this->comment->setContent('1234567890');
    
            $result = $service->checkCommentLength($this->comment);
    
            $this->assertTrue($result);
    }
}
