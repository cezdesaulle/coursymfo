<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    // /**
    //  * @return Produit[] Returns an array of Produit objects
    //  */
    /*
    public function dispos($pack_id, $date_debut, $date_fin)
    {
        return $this->createQueryBuilder('p')
            ->andWhere("p.pack_id = $pack_id", "p.reservation <= $date_fin", "p.reservation >= $date_debut)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Produit
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */



    // equivalent de findAll
    public function findTout()
    {
        return $this->createQueryBuilder('p')
            ->getQuery()
            ->getResult()
       ; 
    }

    public function findPrix($prix) // fonction avec ou sans arguments
    {
        return $this->createQueryBuilder('p')
             //->select('p.nom') // récupérer un champ voulu (sinon par défaut : * (all))
            ->andWhere('p.prix = :prix') // on définit le marqueur   ( prix égal à)
            //->andWhere('p.prix >= :prix') // on définit le marqueur ( prix supérieur ou égal à)
            ->setParameter('prix', $prix) // on associe le marqueur à une valeur
            ->getQuery()
            ->getResult()
       ; 
    }
    // SELECT * FROM produit WHERE prix = 100

    public function findOrder()
    {
        return $this->createQueryBuilder('p')
             //->select('p.nom')
            ->orderBy("p.prix", "ASC") // l'ordonnance, définir quel champ et quel sens (ASC endant et DESC endant)
            ->setMaxResults(3) // LIMIT : on limite une quantité à afficher
            ->getQuery()
            ->getResult()
       ; 
    }

    public function findCategorie($categorie)
    {
        return $this->createQueryBuilder('p')
            ->join('p.category', 'c') // lorsqu'il y a une relation on utilise join() dans lequel on définit le champ et on lui affecte un alias
            ->andWhere('c.id IN (:cat)') // IN peut contenir plusieurs valeurs sur le même (ne fonctionne pas prix = 100 AND prix = 200) on utilise le terme prix IN (100,200)
            ->setParameter('cat', $categorie) // on associe le marqueur à une valeur
            ->getQuery()
            ->getResult()
       ; 
    }

    public function findSearch($search)
    {
        return $this->createQueryBuilder('p')
          
            ->andWhere('p.nom LIKE :mot') // LIKE permet de rechercher un terme dans un champ
            ->orWhere('p.prix LIKE :mot') // orWhere = OU ==> nom like%% OR prix LIKE %%
            ->setParameter('mot', "%{$search}%") // LIKE %a%
            ->getQuery()
            ->getResult()
       ; 
    }







}
