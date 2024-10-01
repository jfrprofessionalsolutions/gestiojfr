<?php

namespace App\Repository;

use App\Entity\ComandaProducte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ComandaProducte>
 *
 * @method ComandaProducte|null find($id, $lockMode = null, $lockVersion = null)
 * @method ComandaProducte|null findOneBy(array $criteria, array $orderBy = null)
 * @method ComandaProducte[]    findAll()
 * @method ComandaProducte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComandaProducteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComandaProducte::class);
    }

    //FRunció que busca els productes que hi ha dins d'una comanda
    public function buscarProductesComanda($idComanda): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.idComanda = :idComanda')
            ->setParameter('idComanda', $idComanda)
            ->getQuery()
            ->getResult()
        ;
    }

    public function add(ComandaProducte $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ComandaProducte $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ComandaProducte[] Returns an array of ComandaProducte objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ComandaProducte
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
