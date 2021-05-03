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
    public function liste_adherant($structure, $region=null)
    {
        $annee = $this->gestionScout->cotisation();
        $cotisations = $this->cotisationRepository->findByAnnee($annee, $structure); //dd($cotisations);
        $lists=[]; $i=0;
        foreach ($cotisations as $cotisation){
            $query = $this->scoutRepository->findRegDistGroup($cotisation->getScout()->getId(), $region); //dd($groupe);
            if ($query){
                $lists[$i]=[
                    'region' => $query[0]->getGroupe()->getDistrict()->getRegion()->getNom(),
                    'district' => $query[0]->getGroupe()->getDistrict()->getNom(),
                    'groupe' => $query[0]->getGroupe()->getParoisse(),
                    'nom' => $query[0]->getNom(),
                    'prenom' => $query[0]->getPrenoms(),
                    'dateNaissance' => $query[0]->getDatenaiss(),
                    'fonction' => $query[0]->getFonction(),
                    'matricule' => $query[0]->getMatricule(),
                    'montant'=> $cotisation->getMontantSanFrais(),
                    'ristourne'=> $cotisation->getRistourne(),
                    'carte' => $cotisation->getCarte()
                ];
            }

            $i = $i+1;
        } //dd($lists);

        return $lists;
    }


}