<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 * fields={"email"},
 * message="Cet email est déjà associé à un compte"
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez renseigner l'email")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez renseigner le mot de passe")
     * @Assert\EqualTo(
     * propertyPath="confirm_password",
     * message="Les mots de passe ne sont pas identiques"
     * )
     */
    private $password;

    /**
     * @Assert\NotBlank(message="Veuillez renseigner la confirmation du mot de passe")
     */
    public $confirm_password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez renseigner le nom")
     */
    private $nom;


    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez renseigner le prénom")
     */
    private $prenom;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = ['ROLE_USER'];




    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }


    // L'entity User est l'entity par laquelle les utilisateurs vont s'inscrire et se connecter
    // Sur elle, repose la sécurité
    // On doit implémenter une classe sur User ==> UserInterface
    // avec elle, on doit inclure des fonctions :

    // identifiant
    public function getUsername() : ?string
    {
        return (string) $this->email;
    }



    public function getRoles() 
    {
        $roles = $this->roles;
        return array_unique($roles);
    }

    public function setRoles(array $roles)
    {
        $this->roles = $roles;
        return $this;
    }

    // renvoie la string non encodé que l'utilisateur a saisi
    public function getSalt(){}

    // nettoyer les mdp en texte brut
    public function eraseCredentials(){}



}
