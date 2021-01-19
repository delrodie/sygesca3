<?php

namespace App\Repository;

use App\Entity\Groupe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Groupe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Groupe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Groupe[]    findAll()
 * @method Groupe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Groupe::class);
    }

    /**
     * @param $district
     * @return int|mixed|string
     */
    public function findByDistrict($district)
    {
        return $this->createQueryBuilder('g')
            ->addSelect('d')
            ->leftJoin('g.district', 'd')
            ->where('d.slug = :district')
            ->orderBy('g.paroisse', 'ASC')
            ->setParameter('district', $district)
            ->getQuery()->getResult();
    }

    public function findEquipeDistrict($district)
    {
        return $this->createQueryBuilder('g')
            ->addSelect('d')
            ->leftJoin('g.district', 'd')
            ->where('d.id = :district')
            ->andWhere('g.paroisse LIKE :groupe')
            ->orWhere('g.paroisse LIKE :groupe2')
            ->setParameters([
                'district' => $district,
                'groupe' => "%Equipe de district%",
                'groupe2' => "%EQUIPES de distrticts"
            ])
            ->getQuery()->getResult()
            ;
    }

    // /**
    //  * @return Groupe[] Returns an array of Groupe objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Groupe
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
