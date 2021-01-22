<?php

namespace App\Repository;

use App\Entity\UserInfo2020;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserInfo2020|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserInfo2020|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserInfo2020[]    findAll()
 * @method UserInfo2020[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserInfo2020Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserInfo2020::class);
    }

    public function findList($region=null, $district=null, $groupe=null)
    {
        $q =  $this->createQueryBuilder('u')
            ->addSelect('r')
            ->addSelect('d')
            ->addSelect('g')
            ->addSelect('f')
            ->leftJoin('u.region', 'r')
            ->leftJoin('u.district', 'd')
            ->leftJoin('u.groupe', 'g')
            ->leftJoin('u.fonction', 'f')
            ;
        if ($region){
            $q->where('r.id = :region')
                ->setParameter('region', $region);
        }elseif ($district){
            $q->where('d.id = :district')
                ->setParameter('district', $district);
        }elseif ($groupe){
            $q->where('g.id = :groupe')
                ->setParameter('groupe', $groupe);
        }else{
            $q=$q;
        }

        return $q->getQuery()->getResult();
    }

    // /**
    //  * @return UserInfo2020[] Returns an array of UserInfo2020 objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserInfo2020
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
