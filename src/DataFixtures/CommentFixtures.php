<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class CommentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
       
        for($i = 1; $i <=10; $i++) {

        $comment = new Comment();
        $comment->setContent("Contenu du commentaire");
        $comment->setCommentDate(new \DateTime());
        $comment->setAuthor("Clément");
        $comment->setArticle($this->getReference("article_1"));

        $manager->persist($comment);      
        
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ArticleFixtures::class,
        ];
    }
}
