<?php


namespace App\Utilities;


use App\Repository\CotisationRepository;
use App\Repository\ScoutRepository;
use Symfony\Component\HttpFoundation\Request;

class GestionRequete
{
    private $cotisationRepository;
    private $scoutRepository;
    private $gestionScout;

    public function __construct(GestionScout $gestionScout, ScoutRepository $scoutRepository, CotisationRepository $cotisationRepository)
    {
        $this->scoutRepository = $scoutRepository;
        $this->cotisationRepository = $cotisationRepository;
        $this->gestionScout = $gestionScout;
    }

    /**
     * Liste globale des adherants
     *
     * @return array
     */
    public function liste_adherant($structure=null, $region=null)
    {
        $annee = $this->gestionScout->cotisation();
        $cotisations = $this->cotisationRepository->findByAnnee($annee); //dd($cotisations);
        $lists=[]; $i=0;
        foreach ($cotisations as $cotisation){
            $lists[$i++] = [
                'region' => $cotisation->getScout()->getGroupe()->getDistrict()->getRegion()->getNom(),
                'district'=> $cotisation->getScout()->getGroupe()->getDistrict()->getNom(),
                'groupe' => $cotisation->getScout()->getGroupe()->getParoisse(),
                'nom' => $cotisation->getScout()->getNom(),
                'prenom' => $cotisation->getScout()->getPrenoms(),
                'dateNaissance' => $cotisation->getScout()->getDatenaiss(),
                'fonction' => $cotisation->getFonction(),
                'matricule' => $cotisation->getScout()->getMatricule(),
                'montant' => $cotisation->getMontantSanFrais(),
                'ristourne' => $cotisation->getRistourne(),
                'carte' => $cotisation->getCarte()
            ];
        } //dd($lists);

        return $lists;
    }


    public function liste_ristourne()
    {
        $annee = $this->gestionScout->cotisation();
        $scouts = $this->scoutRepository->findAllByRistourne($annee); //dd($cotisations);
        $lists=[]; $i=0;
        foreach ($scouts as $scout){
            $cotisation = $this->cotisationRepository->findOneBy(['scout'=>$scout->getId()], ['id'=>'DESC']);
            $lists[$i++] = [
                'region' => $scout->getGroupe()->getDistrict()->getRegion()->getNom(),
                'district'=> $scout->getGroupe()->getDistrict()->getNom(),
                'groupe' => $scout->getGroupe()->getParoisse(),
                'nom' => $scout->getNom(),
                'prenom' => $scout->getPrenoms(),
                'dateNaissance' => $scout->getDatenaiss(),
                'fonction' => $scout->getFonction(),
                'matricule' => $scout->getMatricule(),
                'montant' => $cotisation->getMontantSanFrais(),
                'ristourne' => $cotisation->getRistourne(),
                'carte' => $cotisation->getCarte()
            ];
        } //dd($lists);

        return $lists;
    }


}