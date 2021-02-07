<?php

namespace App\Repository;

use App\Entity\Requete;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Requete|null find($id, $lockMode = null, $lockVersion = null)
 * @method Requete|null findOneBy(array $criteria, array $orderBy = null)
 * @method Requete[]    findAll()
 * @method Requete[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RequeteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Requete::class);
    }

    public function findByStatut($statut, $region=null)
    {
        $q = $this->createQueryBuilder('r')
            ->addSelect('re')
            ->leftJoin('r.region', 're')
            ->where('r.statut = :statut')
            ;
        if ($region){
            $q->andWhere('re.id = :region')
                ->setParameters([
                    'statut' => $statut,
                    'region' => $region
                ]);
        }else{
            $q->setParameter('statut', $statut);
        }

        return $q->orderBy('r.createdAt', "DESC")->getQuery()->getResult();
    }

    public function findByRegion($region = null)
    {
        $q = $this->createQueryBuilder('r')
            ->addSelect('re')
            ->leftJoin('r.region', 're')
            ;
        if ($region){
            $q->where('re.id = :region')
                ->setParameter('region', $region);
        }

        return $q->orderBy('r.createdAt', "DESC")
            ->getQuery()->getResult()
        ;

    }

    // /**
    //  * @return Requete[] Returns an array of Requete objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Requete
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
