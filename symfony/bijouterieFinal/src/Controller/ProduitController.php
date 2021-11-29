<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Service\DateFr;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProduitController extends AbstractController
{


    /**
     * La fonction catalogue() permet d'afficher tous les produits de la table produit 
     * 
     * @Route("/catalogue", name="catalogue")
     */
    public function catalogue(ProduitRepository $repoProduit): Response
    {
        // entre les parenthèses de la fonction on apppelle les dependances
        // ==> tout ce qu'on a besoin dans la fonction

        //$repoProduit = $this->getDoctrine()->getRepository(Produit::class);
 
        $categories = [ 3 , 5 ];
        $search = "1";
        $produits = $repoProduit->findAll(); // findAll = SELECT * FROM table
        //dd($produits);

        // $tab=[];
        // foreach($produits as $produit){
        //     $var=$produit->getDateAt();
        //     array_push($tab,$var);
        // }
        // dd($tab);

        //dd($tabDate);

        //dd($produits);

        $userId = $this->getUser()->getId();

        //dd($userId);



        // METHODES DU REPOSITORY

        // ->findAll() => SELECT * FROM Produit
        //$produits = $repoProduit->findAll();



        // ->findById($id) => SELECT * FROM Produit WHERE id = $id
        // à l'interieur du tableau, est généré un tableau du produit
        // $produits = $repoProduit->findById(17);

        // ->find($id) => SELECT * FROM Produit WHERE id = $id
        // à l'intérieUr du tableau, on retrouve directement les données du produit
        // $produits = $repoProduit->find(17);


        // ->findBy() reçoit un tableau []
        // "nom du champ" => "valeur du champ"
        // SELECT * FROM produit WHERE prix = 100 AND category = 1
        // ==> WHERE et AND
        // ->findBy([ 'prix'=> 100,'category' => 1 ]);










        //dd($produits);
        // dump() : affiche dans la navbar de symfony, la "cible"
        // dump(); die; : die => la suite du code n'est pas "lue"
        // ==> dd();


        return $this->render('produit/catalogue.html.twig', [
            "produits" => $produits
        ]);
    }

    /**
     * la fonction fiche_produit() permet d'afficher la fiche d'un produit existant 
     * 
     * @Route("/fiche_produit/{id}", name="fiche_produit")
     */
    public function fiche_produit(Produit $produit, DateFr $dateFr)
    {                           // $id, ProduitRepository $repoProduit
       //dd($produit);
        //dd($id);
        // find($id) = SELECT * FROM produit WHERE id = $id
        //$produit = $repoProduit->find($id);
        //dd($produit);

        $date_enregistrement = $produit->getDateAt();
        //dd($date_enregistrement);
        $mois = $date_enregistrement->format('m');
        //dd($mois);

        $moisReturn = $dateFr->moisFr($mois);
        //dd($moisReturn);

        // afficher sur twig, la date en français : ex: 16 avril 2021
        $dateAt = $date_enregistrement->format('d') . " " . strtolower($moisReturn) . " " . $date_enregistrement->format('Y');

        
       // dd($dateAt);


        return $this->render('produit/fiche_produit.html.twig', [
            'produit' => $produit,
            'date' => $dateAt

            
        ]);
    }


   
    
}
