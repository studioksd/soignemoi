<?php

namespace App\Repository;

use App\Entity\AvisMedecin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AvisMedecin>
 *
 * @method AvisMedecin|null find($id, $lockMode = null, $lockVersion = null)
 * @method AvisMedecin|null findOneBy(array $criteria, array $orderBy = null)
 * @method AvisMedecin[]    findAll()
 * @method AvisMedecin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AvisMedecinRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AvisMedecin::class);
    }

//    /**
//     * @return AvisMedecin[] Returns an array of AvisMedecin objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AvisMedecin
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
