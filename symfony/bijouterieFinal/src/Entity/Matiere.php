<?php

namespace App\Entity;

use App\Repository\MatiereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


// Les relations :
// Produit et Category 
// sur l'entity Produit ==> ManyToOne
// 1 produit a 1 categorie
// 1 catégorie contient plusieurs produits

// mappedBy 'vs' inversedBy
// la propriété mappedby est celle qui aura son champ en bdd
// dans Category : mappedBy="category" (la propriété category est sur l'entity Produit)
// ==> c'est sur la table produit qu'on trouvera le champ category


// Produit et Matiere
// ManyToMany
// 1 produit peut avoir plusieurs matières
// 1 matière peut avoir plusieurs produits

// Lorsqu'on créé un produit dans le formulaire on défini les matières
// donc un produit qui est constitué de matières
// la propriété mappedby doit appartenir à l'entity Produit
// attention pas écrite sur le fichier Produit.php
// Sur la table Produit on ne peut créer le champ 
// va être généré, une table "extension" de Produit 
// le nom sera une fusion des 2 entités
// indice : le premier nom est la table qui contient la propriété mappedBy
// ex : produit_matiere

/**
 * @ORM\Entity(repositoryClass=MatiereRepository::class)
 */
class Matiere
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\ManyToMany(targetEntity=Produit::class, mappedBy="matieres")
     */
    private $produit;

    public function __construct()
    {
        $this->produit = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|Produit[]
     */
    public function getProduit(): Collection
    {
        return $this->produit;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produit->contains($produit)) {
            $this->produit[] = $produit;
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        $this->produit->removeElement($produit);

        return $this;
    }
}
