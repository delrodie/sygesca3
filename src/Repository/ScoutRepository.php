<?php

namespace App\Repository;

use App\Entity\Scout;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Scout|null find($id, $lockMode = null, $lockVersion = null)
 * @method Scout|null findOneBy(array $criteria, array $orderBy = null)
 * @method Scout[]    findAll()
 * @method Scout[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScoutRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Scout::class);
    }

    /**
     * @param $region
     * @param $annee
     * @return int|mixed|string
     */
    public function findByRegion($region, $annee)
    {
        return $this->createQueryBuilder('s')
            ->leftJoin('s.groupe','g')
            ->leftJoin('g.district','d')
            ->leftJoin('d.region','r')
            ->where('r.id = :id')
            ->andWhere('s.cotisation = :anne')
            ->setParameters([
                'id'=>$region,
                'anne'=> $annee
            ])
            ->getQuery()->getResult()
            ;
    }

    /**
     * Liste
     * @param $scout
     * @return int|mixed|string|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getRegion($scout)
    {
        return $this->createQueryBuilder('s')
            ->select('r.nom')
            ->leftJoin('s.groupe', 'g')
            ->leftJoin('g.district', 'd')
            ->leftJoin('d.region', 'r')
            ->where('s.id = :scout')
            ->setParameter('scout', $scout)
            ->getQuery()->getOneOrNullResult()
            ;
    }

    /**
     * Liste des scouts par branche
     *
     * @param $statut
     * @param $branche
     * @param $cotisation
     * @param null $region
     * @return int|mixed|string
     */
    public function findByBranche($statut,$branche,$cotisation,$region=null)
    {
        $query = $this->createQueryBuilder('s')
            ->leftJoin('s.statut', 'statut')
            ->where('statut.libelle LIKE :statut')
            ->andWhere('s.branche LIKE :branche')
            ->andWhere('s.cotisation = :annee')
        ;
        if (!$region){
            $q = $query->setParameters([
                'statut' => '%'.$statut.'%',
                'annee'=> $cotisation,
                'branche' => '%'.$branche.'%'
            ]);
        }else{
            $q = $query->leftJoin('s.groupe', 'g')
                ->leftJoin('g.district','d')
                ->leftJoin('d.region', 'r')
                ->andWhere('r.id = :region')
                ->setParameters([
                    'statut'=> $statut,
                    'annee'=> $cotisation,
                    'branche' =>'%'.$branche.'%',
                    'region'=> $region
                ])
                ;
        }
        return $q->getQuery()->getResult();
    }

    /**
     * Liste des scouts par sexe
     *
     * @param $sexe
     * @param $cotisation
     * @param null $region
     * @return int|mixed|string
     */
    public function findBySexe($sexe,$cotisation,$region=null)
    {
        if (!$region){
            $q =$this->createQueryBuilder('s')
                ->where('s.sexe = :sexe')
                ->andWhere('s.cotisation = :annee')
                ->setParameters([
                    'sexe' => $sexe,
                    'annee' => $cotisation
                ])
            ;
        } else{
            $q = $this->createQueryBuilder('s')
                ->leftJoin('s.groupe','g')
                ->leftJoin('g.district', 'd')
                ->leftJoin('d.region','r')
                ->where('s.sexe = :sexe')
                ->andWhere('s.cotisation = :annee')
                ->andWhere('r.id = :region')
                ->setParameters([
                    'sexe' => $sexe,
                    'annee' => $cotisation,
                    'region' =>$region
                ])
            ;
        }
        return  $q
            ->getQuery()->getResult();
    }

    public function fingByStatut($statut,$cotisation,$region=null)
    {
        $query = $this->createQueryBuilder('s')
            ->leftJoin('s.statut', 'statut')
            ->where('s.cotisation = :annee')
            ->andWhere('statut.libelle = :statut')
            ;
        if (!$region){
            $q = 0;
        }else{
            $q = $query->leftJoin('s.groupe','g')
                ->leftJoin('g.district', 'd')
                ->leftJoin('d.region', 'r')
                ->andWhere('r.id = :region')
                ->setParameters([
                    'statut'=> $statut,
                    'annee' => $cotisation,
                    'region' => $region
                ])
                ;
        }

        return $q->getQuery()->getResult();
    }

    // /**
    //  * @return Scout[] Returns an array of Scout objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Scout
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
