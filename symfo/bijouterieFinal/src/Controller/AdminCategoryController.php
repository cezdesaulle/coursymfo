<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Sécurité de AdminCategoryController 
 * 
 * @Route("/admin")
 */

class AdminCategoryController extends AbstractController
{
    /**
     * @Route("/gestion_categorie/afficher", name="category_afficher")
     */
    public function category_afficher(CategoryRepository $repoCategorie)
    {
        $categories = $repoCategorie->findAll();
        
        return $this->render('admin_category/category_afficher.html.twig', [
            "categories" => $categories
        ]);
    }

    /**
     * @Route("/gestion_categorie/ajouter", name="category_ajouter")
     * @Route("/gestion_categorie/modifier/{id}", name="category_modifier")
     */
    public function category_ajouter_modifier(Category $category = null, Request $request, EntityManagerInterface $manager)
    {
        if(!$category)
        {
            $category = new Category;
        }
        

        //dd($category);

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid())
        {
            $idCategory = $category->getId();
            $manager->persist($category); 
            $manager->flush(); 

            if($idCategory !== null )
            {
                $this->addFlash("modifierCategory" , "La catégorie a bien été modifiée");
            }
            else
            {
                $this->addFlash("ajoutCategory" , "La catégorie a bien été ajoutée");
            }
            

            return $this->redirectToRoute("category_afficher");

        }

        return $this->render('admin_category/category_ajouter_modifier.html.twig', [
            "formCategory" => $form->createView(),
            "modification" => $category->getId() !== null,
            "category" => $category
        ]);
    }


    /**
     * @Route("/gestion_categorie/supprimer/{id}", name="category_supprimer")
     */
    public function category_supprimer(Category $category, EntityManagerInterface $manager)
    {
        $manager->remove($category);
        $manager->flush();

        $this->addFlash("suppCategory" , "La catégorie a bien été supprimée");
        
        return $this->redirectToRoute("category_afficher");


    }
}
