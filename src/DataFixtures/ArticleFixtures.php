<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        for($i = 1; $i <= 10; $i++) {
            $article = new Article();
            $article->setTitle("Article n°$i");
            $article->setContent("Contenu de l'article");

            $date = new \DateTime();
            $date->modify("-$i days");

            $article->setCreationDate($date);
            $manager->persist($article);
        }

        

        
        $manager->flush();
    }
}
