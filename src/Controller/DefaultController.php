<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'article_list', methods: ['GET'])]
    public function articleList(ArticleRepository $articleRepository): Response 
    {

        $articles = $articleRepository->findAll();

        return $this->render('default/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('/{id}', name:'article_view', methods: ['GET'])]
    public function articleView(ArticleRepository $articleRepository, int $id): Response
    {

        $article = $articleRepository->find($id);

        return $this->render('default/view.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('article/add', name:'add_article')]
    public function addArticle(EntityManagerInterface $manager): Response
    {

        $article = new Article();
        $article->setTitle("Titre de l'article");
        $article->setContent("Contenu de l'article");
        $article->setCreationDate(new \DateTime());

        $manager->persist($article);
        $manager->flush();

    }
    
}
