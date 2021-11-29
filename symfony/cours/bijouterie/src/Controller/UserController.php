<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

// IS_AUTHENTICATED_FULLY : tous les rôles
// Actuellement il y a 2 rôles : ROLE_USER et ROLE_ADMIN 
// Donc IS_AUTHENTICATED_FULLY = ROLE_USER et ROLE_ADMIN
// is_granted('IS_AUTHENTICATED_FULLY')             => il FAUT un rôle (connecté) pour atteindre la route
// is_granted('IS_AUTHENTICATED_FULLY') == false    => il ne faut pas de rôles (non connecté) pour atteindre la route (il ne faut pas être connecté)


class UserController extends AbstractController
{


    /**
     * @Route("/inscription", name="inscription")
     * @Security(" is_granted('ROLE_USER') == false or is_granted('ROLE_ADMIN') == false ")
     */
    public function inscription(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User;

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {

            //dd($user);

            //$user->getPassword();

            //dd($user->getPassword());

            $hash = $encoder->encodePassword($user , $user->getPassword() );

            //dd($hash);

            $user->setPassword($hash);
            $manager->persist($user);
            $manager->flush();

            // message "inscription ok" affiché sur la redirection
            $this->addFlash("inscription" , $user->getPrenom() . ", votre inscription a bien été prise en compte, vous pouvez vous connecter");


            // redirection 
            return $this->redirectToRoute("connexion");


        }

        return $this->render('user/inscription.html.twig', [
            "formUser" => $form->createView()
        ]);
    }



    /**
     * @Route("/connexion", name="connexion")
     * 
     * @Security(" is_granted('IS_AUTHENTICATED_FULLY') == false ")
     */
    public function connexion()
    {
        return $this->render('user/connexion.html.twig');
    }

    /**
     * @Route("/deconnexion", name="deconnexion")
     * @Security(" is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function deconnexion()
    {
       
    }


    /**
     * La fonction roles() permet de checker après connexion, le rôle de l'utilisateur
     * Redirection en fonction du rôle (ROLE_USER : accueil et ROLE_ADMIN : dashboard)
     * 
     * @Route("/roles", name="roles")
     * @Security(" is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function roles()
    {
        if($this->isGranted('ROLE_ADMIN'))
        {
            return $this->redirectToRoute('dashboard');
        }
        elseif($this->isGranted('ROLE_USER'))
        {
            return $this->redirectToRoute('home');
        }
    }
}
