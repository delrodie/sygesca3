<?php


namespace App\Utilities;


use App\Repository\RegionRepository;
use App\Repository\ScoutRepository;
use Doctrine\ORM\EntityManagerInterface;

class GestionScout
{
    private $regionRepository;
    private $scoutRepository;
    private $em;

    public function __construct(ScoutRepository $scoutRepository, RegionRepository $regionRepository, EntityManagerInterface $entityManager)
    {
        $this->regionRepository = $regionRepository;
        $this->scoutRepository = $scoutRepository;
        $this->em = $entityManager;
    }

    /**
     * Generation du matricule du scout
     *
     * @param $region
     * @return string
     */
    public function matricule($region)
    {
        $region_code = $this->regionRepository->findOneBy(['id'=>$region])->getCode();
        $matricule = $region_code.''.$this->code_aleatoire().''.$this->lettre_aleatoire();

        //Verification de non existence. Si oui, en generer autre
        $exist = $this->scoutRepository->findOneBy(['matricule'=>$matricule]);
        while ($exist){
            $matricule = $region_code.''.$this->code_aleatoire().''.$this->lettre_aleatoire();
            $exist = $this->scoutRepository->findOneBy(['matricule'=>$matricule]);
        }

        return $matricule;
    }

    /**
     * Année de cotisation du scout
     *
     * @return string
     */
    public function cotisation()
    {
        $mois_encours = Date('m', time());
        if ($mois_encours > 10){
            $debut_annee = Date('Y', time());
            $fin_annee = Date('Y', time())+1;
            //$an = Date('y', time())+1;
        }else{
            $debut_annee = Date('Y', time())-1;
            $fin_annee = Date('Y', time());
            //$an = Date('y', time());
        }

        $annee = $debut_annee.'-'.$fin_annee;

        return $annee;
    }

    /**
     * Generation du numero de la carte du scout
     *
     * @param $id
     * @param $region_code
     * @return bool
     */
    public function carte($id, $region_code)
    {
        $mois_encours = Date('m', time());
        if ($mois_encours > 9){
            $an = Date('y', time())+1;
        }else{
            $an = Date('y', time());
        }


        if ($id < 10){
            $num = '0000'.$id;
        }elseif($id < 100){
            $num = '000'.$id;
        }elseif ($id < 1000){
            $num = '00'.$id;
        }elseif ($id < 10000){
            $num = '0'.$id;
        }else{
            $num = $id;
        }

        $carte = $region_code.''.$an.'-'.$num;

        // Mise a jour de la table scout
        $scout = $this->scoutRepository->findOneBy(['id'=>$id]);
        $scout->setCarte($carte);
        $this->em->flush();

        return true;

    }

    /**
     * Generation du code aleatoire pour constituer le matricule du scout
     *
     * @return int
     */
    private function code_aleatoire():int
    {
        return mt_rand(10000,99999);
    }

    /**
     * Generation du lettre aleatoire pour constituer le matricule du scout
     * @return string
     */
    private function lettre_aleatoire():string
    {
        // Liste des lettres de l'alphabet
        $alphabet="ABCDEFGHIJKLMNOPQRSTUVWXYZ";

        return $alphabet[rand(0,25)];
    }

}