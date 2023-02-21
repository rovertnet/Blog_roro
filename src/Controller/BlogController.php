<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Form\ArticleType;
use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ObjectManager;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="app_blog")
     */
    public function index(ArticlesRepository $repo): Response
    {
        $selectArticle = $repo->findAll();
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' =>$selectArticle
        ]);
    }
    /**
     * @Route("/",name="blog_home")
     */
    public function Home(){
        return $this->render("blog/home.html.twig", [
            "title"=>"Bienvenu(e) sur mon blog",
        ]);
    }

    /**
     * @Route("/blog/new", name="ajoutArticle" )
     * @Route("/blog/{id}/edit", name="blog_edit")
     */
    public function form(Articles $article = null,  Request $request){

        if (!$article) {
            $article = new Articles();
        }
        $manager = $this->getDoctrine()->getManager();

        // $form = $this->createFormBuilder($article)
        //              ->add("title")
        //              ->add("content", TextareaType::class)
        //              ->add("image")
        //              ->getForm();

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$article->getId()) {
                 $article->setCreatedAt(new \DateTimeImmutable());
            }
           
            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('article_id', ['id' =>$article->getId()]);
        }

        return $this->render("blog/ajout_article.html.twig", [
            "formArticle" =>$form->createView(),
            "editMod" =>$article ->getId() !==null,
            "title" =>"Création d'un article"
        ]);
    }

    /**
     * @Route("/blog_show/{id}", name="article_id")
     */
    public function Show(Articles $article){

        return $this->render("blog/show.html.twig", [
            "article" => $article
        ]);
    }
}
