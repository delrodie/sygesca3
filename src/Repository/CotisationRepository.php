<?php

namespace App\Repository;

use App\Entity\Cotisation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Cotisation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cotisation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cotisation[]    findAll()
 * @method Cotisation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CotisationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cotisation::class);
    }

    /**
     * Liste des scouts en fonction de l'année
     *
     * @param $annee
     * @param null $region
     * @param null $district
     * @param null $groupe
     * @return int|mixed|string
     */
    public function findByAnnee($annee, $region = null, $district = null, $groupe=null)
    {
        $q = $this->createQueryBuilder('c')
            ->addSelect('s')
            ->addSelect('g')
            ->addSelect('d')
            ->addSelect('r')
            ->leftJoin('c.scout', 's')
            ->leftJoin('s.groupe', 'g')
            ->leftJoin('g.district', 'd')
            ->leftJoin('d.region', 'r')
            ->where('c.annee = :annee');

        if ($region){
            $q->andWhere('r.id = :region')
                ->setParameters([
                    'annee' => $annee,
                    'region' => $region
                ]);
        }elseif ($district){
            $q->andWhere('d.id = :district')
                ->setParameters([
                    'annee' => $annee,
                    'district' => $district
                ]);
        }elseif ($groupe){
            $q->andWhere('g.id = :groupe')
                ->setParameters([
                    'annee' => $annee,
                    'groupe' => $groupe
                ]);
        }
        else{
            $q->setParameter('annee', $annee);
        }

        return $q->getQuery()->getResult();
    }



    // /**
    //  * @return Cotisation[] Returns an array of Cotisation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Cotisation
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
