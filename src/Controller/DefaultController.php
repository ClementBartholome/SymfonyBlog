<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\Category;
use App\Form\ArticleType;
use App\Form\CommentType;
use App\Form\CategoryType;
use App\Service\CommentCheck;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;



class DefaultController extends AbstractController
{
    #[Route('/', name: 'article_list', methods: ['GET'])]
    public function articleList(ArticleRepository $articleRepository): Response 
    {

        $articles = $articleRepository->findBy([
            'state' => 'published',
        ]);

        return $this->render('default/index.html.twig', [
            'articles' => $articles,
            'draft' => false,
        ]);
    }

    #[Route('/{id}', name:'article_view', methods: ['GET', 'POST'])]
    public function articleView(Article $article, Request $request, EntityManagerInterface $manager, CommentCheck $commentService, SessionInterface $session): Response
    {

        $comment = new Comment();
        $comment->setArticle($article);

        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            
            if($commentService->checkCommentLength($comment) === true) {
                $manager->persist($comment);
                $manager->flush();
                return $this->redirectToRoute('article_view', ['id' => $article->getId()]);
            } else {
                $session->getFlashBag()->add('danger', 'Comment is too short! (10 caracters min)');
            }
        }

        return $this->render('default/view.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    #[Route('article/add', name:'add_article')]
    #[Route('article/edit/{id}', name:'edit_article', methods: ['GET', 'POST'])]
    public function addArticle(Article $article = null, Request $request, EntityManagerInterface $manager): Response
    {
    
        if ($article === null) {
            $article = new Article();
        }

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            if($form->get('draft')->isClicked()) {
                $article->setState('draft');
            } else {
                $article->setState('published');
            }
               
            if($article->getId() === null) {
                $manager->persist($article);
            }
            
            $manager->flush();

            return $this->redirectToRoute('article_list');
           }

        return $this->render('default/add_article.html.twig', [
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

    #[Route('article/draft', name: 'article_draft')]
    public function draft(ArticleRepository $articleRepository): Response 
    {
        $articles = $articleRepository->findBy([
            'state' => 'draft',
        ]);

        return $this->render('default/index.html.twig', [
            'articles' => $articles,
            'draft' => true,
        ]);
    }
}
