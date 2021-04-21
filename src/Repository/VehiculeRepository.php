<?php

namespace App\Repository;

use App\Entity\Vehicule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Vehicule|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vehicule|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vehicule[]    findAll()
 * @method Vehicule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VehiculeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vehicule::class);
    }

    // /**
    //  * @return Vehicule[] Returns an array of Vehicule objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Vehicule
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findVehiculeDispo($date)
    {
       $conn = $this->getEntityManager()->getConnection();
       $stmt = $conn->prepare("
       SELECT DISTINCT vehicule.immatriculation,modele.nom,modele.nb_places FROM vehicule
       INNER JOIN location ON location.le_vehicule_id=vehicule.id 
       INNER JOIN modele ON modele.id=vehicule.le_modele_id
       WHERE location.location_type='AC' and vehicule.id NOT IN (SELECT location.le_vehicule_id from vehicule INNER JOIN location ON location.le_vehicule_id=vehicule.id where location.date_location=:date )
       ");
    
       $stmt->execute(['date' => $date]);
       return $stmt->fetchAll();
    }
}
