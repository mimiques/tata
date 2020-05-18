<?php

namespace App\Repository;

use App\Entity\Thermo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Thermo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Thermo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Thermo[]    findAll()
 * @method Thermo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ThermoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Thermo::class);
    }
/**
*recuperation des thermo-hygros
* @return Thermo[]
*/
    //public function findFiltres(): array
    //{
    //    return $this->findAll();
   // }
}
