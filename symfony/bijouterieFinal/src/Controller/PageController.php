<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PageController extends AbstractController // hérite d'un autre classe
{


    /**
     * @Route("", name="home")
     */
    public function home()
    {
        return $this->render("page/home.html.twig");
    }

    // local : localhost:8000 
    // web : www.site.fr/


    /**
     * la fonction index() permet de ....
     * 
     * @Route("/page", name="pageName")
     * 1e : URL
     * 2e : nom de la route (les liens <a>)
     */
    public function page(): Response
    {
        $prenom = "Louis";


        return $this->render('page/index.html.twig', [
            'prenomTwig' => $prenom,
            'age' => 10
            // entre quote la valeur récupérée sur twig
            // après => c'est la variable créée sur le controller 


        ]);
        // render relie avec la vue twig
        // 1e argument : le fichier html.twig
        // 2e argument : un tableau

    }

    /**
     * la fonction contact() permet l'envoie du formulaire de contact 
     * 
     * @Route("/contact", name="contact")
     */

    public function contact()
    {

        return $this->render('page/contact.html.twig');

    }



    // créez une route pour la page principale (index)
    // pour la route : localhost:8000 
    // function
    // ==> twig 



    // vider le cache

    // navigateur : CTRL + F5  OU CTRL + MAJ + R


    // Symfony : php bin/console cache:clear
            // OU supprimer le dossier cache dans le dossier var



    // une ORM (Object relationnal mapping) c'est une relation entre une application et une base de données
    // pas besoin de gérer la bdd depuis PhpMyAdmin
    // ORM que Symfony utilise, s'appelle Doctrine
    //

}
