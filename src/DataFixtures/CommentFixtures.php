<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CommentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
       
        $faker = Factory::create();

        for($i = 1; $i <=25; $i++) {

        $comment = new Comment();
        $comment->setContent($faker->paragraph);
        $comment->setCommentDate(new \DateTime());
        $comment->setAuthor($faker->name);
        $comment->setArticle($this->getReference('article_' . rand(1, 10)));

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
