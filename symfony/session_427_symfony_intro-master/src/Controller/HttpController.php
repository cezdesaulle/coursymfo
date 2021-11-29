<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/http")
 */
class HttpController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index()
    {
        return $this->render('http/index.html.twig', [
            'controller_name' => 'HttpController',
        ]);
    }

    /**
     * @Route("/requete")
     */
    public function requete(Request $request)
    {
        // http://localhost:8000/http/requete?nom=Marx&prenom=Groucho
        dump($_GET); // ["nom" => "Marx", "prenom" => "Groucho"]

        // $request->query contient un objet qui est une surcouche à $_GET
        dump($request->query->all());  // ["nom" => "Marx", "prenom" => "Groucho"]

        // $_GET['prenom']
        echo $request->query->get('prenom'); // Groucho

        // notice : undefined index
        //dump($_GET['surnom']);

        // pas de notice si la clé n'existe pas
        dump($request->query->get('surnom')); // null

        // valeur par défaut si la clé n'existe pas
        dump($request->query->get('surnom', 'John Doe')); // John Doe

        // isset($_GET['surnom'])
        dump($request->query->has('surnom')); // false

        echo '<br>' . $request->getMethod(); // GET ou POST

        // si la page a été appelée en POST
        if ($request->isMethod('POST')) {
            // $request->request contient un objet qui est une surcouche à $_POST
            // et contient les mêmes méthodes que $request->query
            dump($request->request->all());

            echo $request->request->get('nom');
        }

        return $this->render('http/requete.html.twig');
    }

    /**
     * On utilise un paramètre typé SessionInterface
     * pour accéder à la session dans une méthode de contrôleur
     *
     * @Route("/session")
     */
    public function session(SessionInterface $session)
    {
        // pour ajouter des éléments à la session :

        $session->set('prenom', 'Julien');
        $session->set('nom', 'Anest');

         // les éléments enregistrés par l'objet Session le sont
        // dans $_SESSION['_sf2_attributes']
        dump($_SESSION);
        var_dump($_SESSION);
        // pour accéder directement aux élément enregistrés
        // par l'objet session
        dump($session->all());

        // pour accéder à un élément de la session
        echo $session->get('prenom');

        // pour supprimer un élément de la session
        $session->remove('nom');

        dump($session->all());

        // pour vider la session
        $session->clear();

        dump($session->all());

        return $this->render('http/session.html.twig');
    }

    /**
     * Une méthode de contrôleur doit nécessairement retourner
     * un objet instance de la classe Symfony\Component\HttpFoundation\Response
     *
     * @Route("/reponse")
     */
    public function reponse(Request $request)
    {
        // http://localhost:8000/http/reponse?type=text
        if ($request->query->get('type') == 'text') {
            $response = new Response('Contenu en texte brut');

            return $response;
        // http://localhost:8000/http/reponse?type=json
        } elseif ($request->query->get('type') == 'json') {
            $response = [
                'nom' => 'Marx',
                'prenom' => 'Groucho'
            ];

            // return new Response(json_encode($response));

            // encode le tableau $response en json
            // et retourne une réponse avec l'entête HTTP
            // Content-Type: application/json au lieu de text/html
            return new JsonResponse($response);
        // http://localhost:8000/http/reponse?found=no
        } elseif ($request->query->get('found') == 'no') {
            // pour retourner une 404, on jette cette exception
            throw new NotFoundHttpException();
        // http://localhost:8000/http/reponse?redirect=index
        } elseif ($request->query->get('redirect') == 'index') {
            // redirection vers une page en passant le nom de sa route
            return $this->redirectToRoute('app_index_index');
        // http://localhost:8000/http/reponse?redirect=bonjour
        } elseif ($request->query->get('redirect') == 'bonjour') {
            // redirection vers une route qui contient un partie variable
            return $this->redirectToRoute(
                'app_index_bonjour',
                [
                    'qui' => 'le monde'
                ]
            );
        }

        // retourne un objet Response dont le contenu est
        // le HTML construit par le template
        return $this->render('http/reponse.html.twig');
    }

    /*
     * Faire une page avec un formulaire en post avec :
     * - email (text)
     * - message (textarea)
     *
     * Si le formulaire est envoyé, vérifier que les deux champs sont remplis
     * Si non, afficher un message d'erreur
     * Si oui, enregistrer les valeurs en session et rediriger vers
     * une nouvelle page qui les affiche et vide la session
     * Dans cette page, si la session est vide, on redirige vers le formulaire
     */

    /**
     * @Route("/formulaire")
     */
    public function formulaire(Request $request, SessionInterface $session)
    {
        $erreur = '';

        // si le formulaire en POST a été envoyé
        if ($request->isMethod('POST')) {
            // $data contient tout $_POST
            $data = $request->request->all();

            if (!empty($data['email']) && !empty($data['message'])) {
                $session->set('email', $data['email']);
                $session->set('message', $data['message']);

                dump($session->all());
            } else {
                $erreur = 'Tous les champs sont obligatoires';
            }
        }

        return $this->render(
            'http/formulaire.html.twig',
            [
                'erreur' => $erreur
            ]
        );
    }
}
