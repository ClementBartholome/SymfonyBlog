<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\Category;
use App\Form\ArticleType;
use App\Form\CommentType;
use App\Form\CategoryType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;



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

    #[Route('/{id}', name:'article_view', methods: ['GET', 'POST'])]
    public function articleView(Article $article, Request $request, EntityManagerInterface $manager): Response
    {
        $comment = new Comment();
        $comment->setArticle($article);

        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($comment);
            $manager->flush();
            return $this->redirectToRoute('article_view', ['id' => $article->getId()]);
        }

        return $this->render('default/view.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    #[Route('article/add', name:'add_article')]
    public function addArticle(Request $request, EntityManagerInterface $manager): Response
    {

        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
               
            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('article_list');
           }

        return $this->render('default/add.html.twig', [
                'form' => $form->createView(),
        ]);
    }
    

    #[Route('category/add', name: 'add_category')]
    public function addCategory(Request $request, EntityManagerInterface $manager): Response 
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($category);
            $manager->flush();

            return $this->redirectToRoute('article_list');
        }

        return $this->render('default/add_category.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
