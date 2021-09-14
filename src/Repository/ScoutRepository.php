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

    /**
     * @param $scout
     * @return int|mixed|string
     */
    public function findRegDistGroup($scout, $region = null)
    {
        $query = $this->createQueryBuilder('s')
            ->addSelect( 'g')
            ->addSelect( 'd')
            ->addSelect( 'r')
            ->leftJoin('s.groupe', 'g')
            ->leftJoin('g.district', 'd')
            ->leftJoin('d.region', 'r')
            ->where('s.id = :scout')
            ;
        if ($region){
            $query->andWhere('r.id >= 4')->andWhere('r.id <= 18');
        }
        $q = $query->setParameter('scout', $scout)->getQuery()->getResult();
        return $q;
    }

    public function findByFonction($fonction, $annee)
    {
        return $this->createQueryBuilder('s')
            ->addSelect('g')
            ->addSelect('d')
            ->addSelect('r')
            ->leftJoin('s.groupe', 'g')
            ->leftJoin('g.district', 'd')
            ->leftJoin('d.region', 'r')
            ->where('s.fonction LIKE :fonction')
            ->andWhere('s.cotisation = :annee')
            ->setParameters([
                'fonction' => "%".$fonction."%",
                'annee' => $annee
            ])
            ->getQuery()->getResult()
            ;
    }

    public function findBySearch($variable)
    {
        return $this->createQueryBuilder('s')
            ->addSelect('g')
            ->addSelect('d')
            ->addSelect('r')
            ->addSelect('st')
            ->leftJoin('s.groupe', 'g')
            ->leftJoin('g.district', 'd')
            ->leftJoin('d.region', 'r')
            ->leftJoin('s.statut', 'st')
            ->where('s.nom LIKE :variable')
            ->orWhere('s.prenoms LIKE :variable')
            ->orWhere('s.matricule LIKE :variable')
            ->setParameter('variable', '%'.$variable.'%')
            ->getQuery()->getResult()
            ;
    }

    /**
     * Recherche par genre te statut par region
     *
     * @param $region
     * @param $statut
     * @param $genre
     * @param $annee
     * @return int|mixed|string
     */
    public function findByGenre($region, $statut, $genre, $annee, $genre2 = null)
    {
        return $this->createQueryBuilder('s')
            ->addSelect('g')
            ->addSelect('d')
            ->addSelect('r')
            ->addSelect('st')
            ->leftJoin('s.groupe', 'g')
            ->leftJoin('g.district', 'd')
            ->leftJoin('d.region', 'r')
            ->leftJoin('s.statut', 'st')
            ->where('r.id = :region')
            ->andWhere('st.id = :statut')
            ->andWhere('s.sexe = :genre OR s.sexe = :genre2')
            ->andWhere('s.cotisation = :annee')
            ->setParameters([
                'region' => $region,
                'statut' => $statut,
                'genre' => $genre,
                'genre2' => $genre,
                'annee' => $annee
            ])
            ->getQuery()->getResult()
            ;
    }

    /**
     * @param $district
     * @param $statut
     * @param $genre
     * @param $annee
     * @return int|mixed|string
     */
    public function findByGenreDistrict($district, $statut, $genre, $annee, $genre2)
    {
        return $this->createQueryBuilder('s')
            ->addSelect('g')
            ->addSelect('d')
            ->addSelect('st')
            ->leftJoin('s.groupe', 'g')
            ->leftJoin('g.district', 'd')
            ->leftJoin('s.statut', 'st')
            ->where('d.id = :district')
            ->andWhere('st.id = :statut')
            ->andWhere('s.sexe = :genre OR s.sexe = :genre2')
            ->andWhere('s.cotisation = :annee')
            ->setParameters([
                'district' => $district,
                'statut' => $statut,
                'genre' => $genre,
                'genre2' => $genre2,
                'annee' => $annee
            ])
            ->getQuery()->getResult()
            ;
    }

    public function getNombreByDistrict($district, $annee)
    {
        return $this->createQueryBuilder('s')
            ->addSelect('g')
            ->addSelect('d')
            ->leftJoin('s.groupe', 'g')
            ->leftJoin('g.district', 'd')
            ->where('d.id = :district')
            ->andWhere('s.cotisation = :annee')
            ->setParameters([
                'district' => $district,
                'annee' => $annee
            ])
            ->getQuery()->getResult()
            ;
    }

    /**
     * @param $annee
     * @return int|mixed|string
     */
    public function findAllByRistourne($annee)
    {
        return $this->createQueryBuilder('s')
            ->addSelect('g')
            ->addSelect('d')
            ->addSelect('r')
            ->leftJoin('s.groupe', 'g')
            ->leftJoin('g.district', 'd')
            ->leftJoin('d.region', 'r')
            ->where('s.cotisation = :annee')
            ->setParameter('annee', $annee)
            ->getQuery()->getResult()
            ;
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
