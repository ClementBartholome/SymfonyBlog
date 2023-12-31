<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $state = ['draft', 'published'];

        for ($i = 1; $i <= 10; $i++) {
            $article = new Article();
            $article->setTitle($faker->text(50));
            $article->setContent($faker->paragraph(25));
            $article->setState($state[array_rand($state)]);

            $date = $faker->dateTimeBetween('-10 days', 'now');
            $article->setCreationDate($date);

            $this->addReference("article_$i", $article);

            $manager->persist($article);
        }

        $manager->flush();
    }
}
