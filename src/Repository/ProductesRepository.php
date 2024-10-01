<?php

namespace App\Repository;

use App\Entity\Productes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Productes>
 *
 * @method Productes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Productes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Productes[]    findAll()
 * @method Productes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Productes::class);
    }

    //Funció que busca la info d' un producte en concret
    public function buscarProducte($idProducte): array
    {
        return $this->createQueryBuilder('c')
            ->select('c.idProducte, c.producte, c.preu')
            ->andWhere('c.idProducte = :idProducte')
            ->setParameter('idProducte', $idProducte)
            ->orderBy('c.idProducte', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function add(Productes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Productes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //Funció que busca la informació de tots els productes
    public function buscarProductes(): array
    {
        return $this->createQueryBuilder('c')
            ->select('c.idProducte, c.producte, c.preu')
            ->getQuery()
            ->getResult()
        ;
    }

//    /**
//     * @return Productes[] Returns an array of Productes objects
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

//    public function findOneBySomeField($value): ?Productes
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
