<?php

namespace App\Repository;

use App\Entity\Niveau;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Niveau|null find($id, $lockMode = null, $lockVersion = null)
 * @method Niveau|null findOneBy(array $criteria, array $orderBy = null)
 * @method Niveau[]    findAll()
 * @method Niveau[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NiveauRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Niveau::class);
    }

    // /**
    //  * @return Niveau[] Returns an array of Niveau objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */


    public function findOneByName($value): ?Niveau
    {
        return $this->createQueryBuilder('n')
            ->where('n.leveltitle LIKE :val')
            ->setParameter('val', '%' . $value . '%')
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Enregistrements dont un champ contientune valeur
     * ou tous les enregistrements si la valeur est vide
     * @param type $champ
     * @param type $valeur
     * @return Niveau[]
     */
    public function findByContainValue($champ, $valeur): array
    {
        if ($valeur == "") {
            return $this->createQueryBuilder('f')
                ->orderBy('f.' . $champ, 'ASC')
                ->getQuery()
                ->getResult();
        } else {
            return $this->createQueryBuilder('f')
                ->where('f.' . $champ . ' LIKE :valeur')
                ->setParameter('valeur', '%' . $valeur . '%')
                ->getQuery()
                ->getResult();
        }
    }
}
