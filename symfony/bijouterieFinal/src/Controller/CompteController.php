<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
* @Route("/profil")
*/

class CompteController extends AbstractController
{
    /**
     * @Route("/afficher", name="profil_afficher")
     */
    public function profil_afficher(): Response
    {
        return $this->render('compte/profil_afficher.html.twig');
    }
}
