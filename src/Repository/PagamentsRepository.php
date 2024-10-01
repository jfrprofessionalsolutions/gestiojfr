<?php

namespace App\Repository;

use App\Entity\Pagaments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pagaments>
 *
 * @method Pagaments|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pagaments|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pagaments[]    findAll()
 * @method Pagaments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PagamentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pagaments::class);
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

    public function add(Pagaments $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Pagaments $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Pagaments[] Returns an array of Pagaments objects
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

//    public function findOneBySomeField($value): ?Pagaments
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
