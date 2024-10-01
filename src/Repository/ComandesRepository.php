<?php

namespace App\Repository;

use App\Entity\Comandes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Comandes>
 *
 * @method Comandes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comandes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comandes[]    findAll()
 * @method Comandes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComandesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comandes::class);
    }

    //Funció que busca totes les comandes amb el nom del client i el nom de l'estat de la comanda
    public function comandes(): array
    {
        return $this->createQueryBuilder('c')
            ->select('c.idComanda, c.nomComanda, c.totalComanda, c.idEstat, cli.nom, e.estatComanda')
            ->leftJoin('App\\Entity\\Clients', 'cli', 'WITH', 'cli.idClient = c.idClient')
            ->leftJoin('App\\Entity\\EstatsComanda', 'e', 'WITH', 'e.idEstatComanda = c.idEstat')
            ->orderBy('c.idComanda', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    //Funció que busca l'informació d'una comanda en concret
    public function buscarComanda($idComanda): array
    {
        return $this->createQueryBuilder('c')
        ->select('c.idComanda, c.nomComanda, c.totalComanda, c.idEstat, cli.nom as nomClient, e.estatComanda')
            ->leftJoin('App\\Entity\\Clients', 'cli', 'WITH', 'cli.idClient = c.idClient')
            ->leftJoin('App\\Entity\\EstatsComanda', 'e', 'WITH', 'e.idEstatComanda = c.idEstat')
            ->andWhere('c.idComanda = :idComanda')
            ->setParameter('idComanda', $idComanda)
            ->orderBy('c.idComanda', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    //Funció que busca els productes que hi ha a dins d'una comanda
    public function productesComanda($idComanda): array
    {
        return $this->createQueryBuilder('c')
        ->select('c.idComanda, c.nomComanda, c.totalComanda, cp.id as idComandaProducte, cp.unitats, p.idProducte as idProducte, p.producte as producte, p.preu')
            ->leftJoin('App\\Entity\\ComandaProducte', 'cp', 'WITH', 'cp.idComanda = c.idComanda')
            ->leftJoin('App\\Entity\\Productes', 'p', 'WITH', 'p.idProducte = cp.idProducte')
            ->andWhere('cp.idComanda = :idComanda')
            ->setParameter('idComanda', $idComanda)
            ->orderBy('cp.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function add(Comandes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Comandes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function comandesClient($idClient): array
    {
        return $this->createQueryBuilder('c')
            ->select('c.idComanda, c.nomComanda, c.totalComanda, c.idEstat')
            ->andWhere('c.idClient = :idClient')
            ->setParameter('idClient', $idClient)
            ->orderBy('c.idComanda', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    //Funció que busca la ID de la última comanda creada
    public function idNovaComanda(): array
    {
        return $this->createQueryBuilder('c')
            ->select('max(c.idComanda) as idComanda')
            ->getQuery()
            ->getResult()
        ;
    }

//    /**
//     * @return Comandes[] Returns an array of Comandes objects
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

//    public function findOneBySomeField($value): ?Comandes
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
