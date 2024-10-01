<?php

namespace App\Repository;

use App\Entity\Pressupostos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pressupostos>
 *
 * @method Pressupostos|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pressupostos|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pressupostos[]    findAll()
 * @method Pressupostos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PressupostosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pressupostos::class);
    }

    //Funció que busca tots els pressupostos amb el nom del client i el nom de l'estat del pressupost
    public function pressupostos(): array
    {
        return $this->createQueryBuilder('c')
            ->select('c.idPressupost, c.pressupost, c.totalPressupost, c.idEstat, cli.nom, e.estatPressupost')
            ->leftJoin('App\\Entity\\Clients', 'cli', 'WITH', 'cli.idClient = c.idClient')
            ->leftJoin('App\\Entity\\EstatsPressupost', 'e', 'WITH', 'e.idEstatPressupost = c.idEstat')
            ->orderBy('c.idPressupost', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    //Funció que busca l'informació d'un pressupos en concret
    public function buscarPressupost($idPressupost): array
    {
        return $this->createQueryBuilder('c')
        ->select('c.idPressupost, c.pressupost, c.totalPressupost, c.idEstat, cli.nom as nomClient, ep.estatPressupost')
            ->leftJoin('App\\Entity\\Clients', 'cli', 'WITH', 'cli.idClient = c.idClient')
            ->leftJoin('App\\Entity\\EstatsPressupost', 'ep', 'WITH', 'ep.idEstatPressupost = c.idEstat')
            ->andWhere('c.idPressupost = :idPressupost')
            ->setParameter('idPressupost', $idPressupost)
            ->orderBy('c.idPressupost', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    //Funció que busca els productes que hi ha a dins d'un pressupost
    public function productesPressupost($idPressupost): array
    {
        return $this->createQueryBuilder('c')
        ->select('c.idPressupost, c.pressupost, c.totalPressupost, cp.id as idPressupostProducte, cp.unitats, p.idProducte as idProducte, p.producte as producte, p.preu')
            ->leftJoin('App\\Entity\\PressupostProducte', 'cp', 'WITH', 'cp.idPressupost = c.idPressupost')
            ->leftJoin('App\\Entity\\Productes', 'p', 'WITH', 'p.idProducte = cp.idProducte')
            ->andWhere('cp.idPressupost = :idPressupost')
            ->setParameter('idPressupost', $idPressupost)
            ->orderBy('cp.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function add(Pressupostos $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Pressupostos $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //Funció que busca la ID de l'últim pressupost creat
    public function idNouPressupost(): array
    {
        return $this->createQueryBuilder('c')
            ->select('max(c.idPressupost) as idPressupost')
            ->getQuery()
            ->getResult()
        ;
    }

//    /**
//     * @return Pressupostos[] Returns an array of Pressupostos objects
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

//    public function findOneBySomeField($value): ?Pressupostos
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
