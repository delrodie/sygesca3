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

    public function findList()
    {
        return $this->createQueryBuilder('g')
            ->addSelect('d')
            ->addSelect('r')
            ->leftJoin('g.district', 'd')
            ->leftJoin('d.region', 'r')
            ->getQuery()->getResult()
            ;
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

    /**
     * @param null $district
     * @return int|mixed|string
     */
    public function findEquipeDistrict($district = null)
    {
        $q = $this->createQueryBuilder('g')
            ->addSelect('d')
            ->addSelect('r')
            ->leftJoin('g.district', 'd')
            ->leftJoin('d.region', 'r')
            ->where('g.paroisse LIKE :groupe')
        ;
        if ($district){
            $q->andWhere('d.id = :district')
                ->setParameters([
                    'district' => $district,
                    'groupe' => "%Equipe%"
                ]);
        }else{
            $q->setParameter('groupe', "%Equipe%");
        }
        return $q->getQuery()->getResult();
    }

    /**
     * @param $groupe
     * @return int|mixed|string
     */
    public function findByID($groupe)
    {
        return $this->createQueryBuilder('g')
            ->addSelect('d')
            ->addSelect('r')
            ->leftJoin('g.district', 'd')
            ->leftJoin('d.region', 'r')
            ->where('g.id = :groupe')
            ->setParameter('groupe', $groupe)
            ->getQuery()->getSingleResult()
            ;
    }

    public function liste()
    {
        return $this->createQueryBuilder('g');
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
