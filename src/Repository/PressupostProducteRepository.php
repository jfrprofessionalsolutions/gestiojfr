<?php

namespace App\Repository;

use App\Entity\PressupostProducte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PressupostProducte>
 *
 * @method PressupostProducte|null find($id, $lockMode = null, $lockVersion = null)
 * @method PressupostProducte|null findOneBy(array $criteria, array $orderBy = null)
 * @method PressupostProducte[]    findAll()
 * @method PressupostProducte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PressupostProducteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PressupostProducte::class);
    }

    public function buscarProductesPressupost($idPressupost): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.idPressupost = :idPressupost')
            ->setParameter('idPressupost', $idPressupost)
            ->orderBy('c.idPressupost', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function add(PressupostProducte $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PressupostProducte $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return PressupostProducte[] Returns an array of PressupostProducte objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PressupostProducte
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
