<?php

namespace App\Repository;

use App\Entity\EstatsComanda;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EstatsComanda>
 *
 * @method EstatsComanda|null find($id, $lockMode = null, $lockVersion = null)
 * @method EstatsComanda|null findOneBy(array $criteria, array $orderBy = null)
 * @method EstatsComanda[]    findAll()
 * @method EstatsComanda[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EstatsComandaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EstatsComanda::class);
    }

    public function add(EstatsComanda $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //Busca un estat de comanda en concret
    public function buscarEstatComanda($idEstatComanda): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.idEstatComanda = :idEstatComanda')
            ->setParameter('idEstatComanda', $idEstatComanda)
            ->orderBy('c.idEstatComanda', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    //Busca tots els estats de comanda que hi ha
    public function estatsComanda(): array
    {
        return $this->createQueryBuilder('c')
            ->select('c.idEstatComanda, c.estatComanda')
            ->orderBy('c.idEstatComanda', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function remove(EstatsComanda $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return EstatsComanda[] Returns an array of EstatsComanda objects
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

//    public function findOneBySomeField($value): ?EstatsComanda
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
