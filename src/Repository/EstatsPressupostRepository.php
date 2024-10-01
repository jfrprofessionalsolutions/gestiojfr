<?php

namespace App\Repository;

use App\Entity\EstatsPressupost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EstatsComanda>
 *
 * @method EstatsPressupost|null find($id, $lockMode = null, $lockVersion = null)
 * @method EstatsPressupost|null findOneBy(array $criteria, array $orderBy = null)
 * @method EstatsPressupost[]    findAll()
 * @method EstatsPressupost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EstatsPressupostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EstatsPressupost::class);
    }

    public function buscarEstatPressupost($idEstatPressupost): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.idEstatPressupost = :idEstatPressupost')
            ->setParameter('idEstatPressupost', $idEstatPressupost)
            ->orderBy('c.idEstatPressupost', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function add(EstatsPressupost $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(EstatsPressupost $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return EstatsPressupost[] Returns an array of EstatsPressupost objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?EstatsPressupost
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
