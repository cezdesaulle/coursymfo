<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Préfixe de route défini pour la classe :
 * toutes les url des routes définies dans ce contrôleur
 * sont préfixées par /twig
 * @Route("/twig")
 */
class TwigController extends AbstractController
{
    /**
     * Avec le préfixe de route sur la classe, l'url de cette page
     * est /twig ou /twig/
     * @Route("/")
     */
    public function index()
    {
        return $this->render(
            'twig/index.html.twig',
            [
                'demain' => new \DateTime('+1day')
            ]
        );
    }
}
