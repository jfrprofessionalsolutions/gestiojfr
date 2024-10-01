<?php

namespace App\Repository;

use App\Entity\FormesPagament;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FormesPagament>
 *
 * @method FormesPagament|null find($id, $lockMode = null, $lockVersion = null)
 * @method FormesPagament|null findOneBy(array $criteria, array $orderBy = null)
 * @method FormesPagament[]    findAll()
 * @method FormesPagament[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormesPagamentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FormesPagament::class);
    }

    public function buscarPagament($idPagament): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.idPagament = :idPagament')
            ->setParameter('idPagament', $idPagament)
            ->orderBy('c.idPagament', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function add(FormesPagament $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(FormesPagament $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return FormesPagament[] Returns an array of FormesPagament objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?FormesPagament
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
