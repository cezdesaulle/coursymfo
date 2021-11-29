<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


/**
 * On peut annoter un "prefixe" de route avant la class
 * Toutes les routes de cette class héritent de ce préfixe
 * dans Security.yaml (ligne 41), on a défini que toutes les routes commençant par /admin seront accéssible uniquement si le rôle est ROLE_ADMIN  
 * 
 * @Route("/admin")
 */
class AdminController extends AbstractController
{

    /**
     * La fonction dashboard() est la page d'accueil d'un ADMIN
     * 
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboard()
    {

        return $this->render('admin/dashboard.html.twig');
    }

    /**
     * La fonction produit_ajouter() permet d'ajouter un produit en bdd
     * 
     * @Route("/gestion_produit/ajouter", name="produit_ajouter")
     *
     */

     // les annotations sont dans des commentaires elles commençent par un @ suivi du nom de la Class
     // il faut utiliser les double quotes 

     public function ajouter_produit(Request $request, EntityManagerInterface $manager)
     {
         $produit = new Produit;
         //dump($produit);
         // Création d'une instance de la class Produit
         //dd($produit);
 
         // Création d'un formulaire
         // methode createForm()
         // 2 arguments
         // 1e : le formulaire sur lequel on se base : ProduitType:class
         // 2e : l'instance
         // 3e : optionnel : tableau contenant l'option
 
         $form = $this->createForm(ProduitType::class, $produit, array( 
             'ajouter' => true
            ));
         $request->        // la méthode createForm() génère un objet
         // ($form c'est un objet / une instance )
 
         $form->handleRequest($request);// traitement de la requête
         // request est la class qui reproupe toutes les superglobales
         // request->request = $_POST
         // request->query = $_GET
 
         if($form->isSubmitted() && $form->isValid()) // si le formulaire a été soumis (submit) et validé (les champs ok)
         {
             //dd($request);

             //dd($produit);

//         $reservation->setDate(strtotime($request->request->get('date')));
 
             // on recupère toutes les données sur l'input files (image)
            $imageFile = $form->get('image')->getData();
            //dd($imageFile);


            // si une image a été upload, on rentre dans la condition
            // renommer l'image
            // envoyer l'image dans le dossier public / images
            // envoyer le nom de l'image en bdd
            if($imageFile)
            {
                // redéfinir le nom de l'image

                $nomImage = date("YmdHis") . "-" . uniqid() . "-" . $imageFile->getClientOriginalName();
                //dd($nomImage);

                // envoie de l'image dans le dossier public/images 

                try // on exécute le code dans try
                {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $nomImage
                    );

                    // méthode move() permet de déplacer un fichier
                    // 2 arguments :
                    // 1e : le "placement"
                    // 2e : le nom
                }
                catch(FileException $e) // s'il y a une erreur, on récupère l'erreur et on l'affiche ici
                {

                }

                // Envoie du nouveau nom en bdd

                $produit->setImage($nomImage);

            }
            // sinon il n'y a pas d'image upload, produit->getImage() est null 





            // $matieres = $produit->getMatieres();
            // for($i = 0; $i < count($matieres); $i++)
            // {
            //     $produit->addMatiere($matieres[$i]);
                
            //     dump($matieres[$i]);
            // }
            //dd($produit);





           
            // sinon comme image peut être NULL le manager enverra du NULL en bdd

             // envoyer en bdd
             // ne pas oublier qu'il faut que la dateAt ne soit pas null
             // champs qui ne peuvent pas $etre null sont :
             // nom (form)
             // prix (form)
             // dateAt (pas du form ) ==> avant l'envoie en bdd
 
 
             // dump($produit->getNom()); 
             // $produit->setNom("voiture");
             //  dump($produit->getNom()); 
             // getNom() => afficher la valeur du nom
             
             $produit->setDateAt(new \DateTime('now'));
             // setDateAt() => attribuer une valeur à dateAt
 
             dump($produit); 
             // Repository (SELECT) != EntityManagerInterface : éxecution en bdd => (INSERT INTO UPDATE DELETE)
         
             $manager->persist($produit); // on persiste l'instance
             $manager->flush(); // on envoie l'instance en BDD
 
             // Notification sur le navigateur
             // addFlash() permet de véhiculer une string du controller au twig
             // 2 arguments :
             // 1e : le nom du message
             // 2e : le message
             $this->addFlash("ajoutProduit" , "Le produit a bien été ajouté");


             // redirection sur la route produit_afficher
             return $this->redirectToRoute("produit_afficher");
 
             
 
 
         }
 
 
         return $this->render("admin/produit_ajouter.html.twig" , [
             "formProduit" => $form->createView()
         ]);
     }


     /**
      * La fonction afficher_produit() permet d'afficher tous les produits sous forme de tableau (back office)
      *
      * @Route("/gestion_produit/afficher", name="produit_afficher")
      *
      */
      public function afficher_produit(ProduitRepository $repoProduit)
      {
          // Récupération de tous les produits de la table Produit 
          // Repository = Requêtes SELECT
          // findAll() = SELECT * FROM produit
          $produits = $repoProduit->findAll();
          //dd($produits);
          return $this->render("admin/produit_afficher.html.twig" , [
              "produits" => $produits
          ]);
      }


      /**
       * La fonction modifier_produit() permet de modifier un produit existant
       * 
       * @Route("/gestion_produit/modifier/{id}" , name="produit_modifier")
       */
      public function modifier_produit(Produit $produit, Request $request, EntityManagerInterface $manager )
      {
          dump($produit);
            // La différence entre ajouter et modifier un produit 
            // ajouter : $produit est vide
            // modifier : $produit ne l'est pas 
            //dd($produit);

        $form = $this->createForm(ProduitType::class, $produit, array( 
            'modifier' => true
           ));

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            
            //dd($request);
            // Problématique
            // injecter des valeurs dans des inputs est possible grâce à l'attribut value="", cependant il y a une exception avec l'input de type="file", la seule manière pour qu'il contient qqch c'est en chargeant qqch (image/ musique / video / documents)

            // Solution : créer 2 formulaires ('ajouter' et 'modifier') dans ProduitType
            // la différence est le nom de l'input file
            // ajouter : image (Entity)
            // modifier : imageFile (mapped => false)
            
            // si on ne change pas l'image, il faut conserver celle existante
            // lorsque l'input file est image et qu'il ne reçoit pas d'upload, alors image = null
            // pour modifier, on appelle imageFile donc image est inchangé
            // si on veut modifier l'image : ref : ajouter image
            // condition imageFile n'est pas vide : traitement de la condition


            $imageFile = $form->get('imageFile')->getData();

           //dd($imageFile->guessExtension());


            // si une image a été upload, on rentre dans la condition
            // renommer l'image
            // envoyer l'image dans le dossier public / images
            // envoyer le nom de l'image en bdd
            if($imageFile)// ai-je chargé une image ?
            {
                // redéfinir le nom de l'image

                $nomImage = date("YmdHis") . "-" . uniqid() . "-" . $imageFile->getClientOriginalName();
                //dd($nomImage);

                // envoie de l'image dans le dossier public/images 

                try // on exécute le code dans try
                {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $nomImage
                    );

                    // méthode move() permet de déplacer un fichier
                    // 2 arguments :
                    // 1e : le "placement"
                    // 2e : le nom
                }
                catch(FileException $e) // s'il y a une erreur, on récupère l'erreur et on l'affiche ici
                {

                }
                //dd($produit->getImage());

                // si une image est en bdd
                if(!empty($produit->getImage() ))
                {
                    unlink($this->getParameter('images_directory') .'/'. $produit->getImage());
                }
                
                // Envoie du nouveau nom en bdd

                $produit->setImage($nomImage);

            }
            // sinon il n'y a pas d'image upload, produit->getImage() est null 


            if($request->request->get('imageSupp'))// si j'ai coché la checkbox 
            {
                unlink($this->getParameter('images_directory') .'/'. $produit->getImage());
                $produit->setImage(null);
            }




            $manager->persist($produit);
            $manager->flush();

            return $this->redirectToRoute("produit_afficher");

        }




        return $this->render("admin/produit_modifier.html.twig" , [
            "formProduit" => $form->createView(),
            "produit" => $produit
        ]);
      }


      /**
       * La fonction supprimer_produit() permet de modifier un produit existant
       * 
       * @Route("/gestion_produit/supprimer/{id}", name="produit_supprimer")
       */
      public function supprimer_produit(Produit $produit, EntityManagerInterface $manager)
      {
        if(!empty($produit->getImage()))
        {
            unlink($this->getParameter('images_directory') .'/'. $produit->getImage());
        }
        
        $manager->remove($produit);
        $manager->flush();
        

        return $this->redirectToRoute("produit_afficher");
      }
    


      /**
       * La fonction supprimer_image_produit() permet de supprimer l'image d'un produit
       * 
       * @Route("/gestion_produit/modifier/image/{id}", name="image_produit_supprimer")
       */
      public function supprimer_image_produit(Produit $produit, EntityManagerInterface $manager)
      {
        unlink($this->getParameter('images_directory') .'/'. $produit->getImage());
        // unlink() permet de supprimer un fichier dans un dossier du projet
        // 1e argument : chemin / arboresence  d'où se trouve le fichier
        // public/images/imagesUpload . / . 20210408..... .jpg
        // getParameter('images_directory') =   public/images/imagesUpload
        
        $produit->setImage(null);
        $manager->persist($produit);
        $manager->flush();

        return $this->redirectToRoute("produit_modifier" , ['id' => $produit->getId()]);
      }


     
}
