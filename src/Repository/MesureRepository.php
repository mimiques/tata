<?php

namespace App\Repository;

use App\Entity\Mesure;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Mesure|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mesure|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mesure[]    findAll
 * @method Mesure[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MesureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mesure::class);
    }
/*
    public function myFindAll(){
        $queryBuilder = $this ->_em->createQueryBuilder()
            ->select('m')
            ->from($this->_entityName,'m')
            ;
        $query = $queryBuilder->getQuery();
        $results = $query->getResult();
        return $results;
    }*/


public function findByIdJoinedToSalle($mesureId){
        $entityManager=$this->getEntityManager();

        $query= $entityManager->createQuery(
            'SELECT m ,s
            FROM App\Entity\Mesure m
            INNER JOIN m.salle s
            WHERE m.id = :id'
        )->setParameter('id',$mesureId);

       return $query->getOneOrNullResult();
}


    /*
    public function findOneBySomeField($value): ?Mesure
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
