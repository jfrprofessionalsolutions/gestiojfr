<?php

namespace App\Repository;

use App\Entity\TipusPagaments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TipusPagaments>
 *
 * @method TipusPagaments|null find($id, $lockMode = null, $lockVersion = null)
 * @method TipusPagaments|null findOneBy(array $criteria, array $orderBy = null)
 * @method TipusPagaments[]    findAll()
 * @method TipusPagaments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TipusPagamentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TipusPagaments::class);
    }

    public function buscarTipusPagament($idClient): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.idTipusPagament = :idTipusPagament')
            ->setParameter('idTipusPagament', $idTipusPagament)
            ->orderBy('c.idTipusPagament', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function add(TipusPagaments $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TipusPagaments $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return TipusPagaments[] Returns an array of TipusPagaments objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TipusPagaments
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
