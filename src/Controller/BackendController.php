<?php

namespace App\Controller;

use App\Repository\CotisationRepository;
use App\Repository\ObjectifRepository;
use App\Repository\RegionRepository;
use App\Repository\ScoutRepository;
use App\Utilities\GestionScout;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BackendController
 * @Route ("/sygesca")
 */
class BackendController extends AbstractController
{
    private $scoutRepository;
    private $cotisationRepository;
    private $gestionScout;
    private  $regionRepository;
    private $objectifRepository;

    public function __construct(ScoutRepository $scoutRepository, CotisationRepository $cotisationRepository, GestionScout $gestionScout, RegionRepository $regionRepository, ObjectifRepository $objectifRepository)
    {
        $this->scoutRepository = $scoutRepository;
        $this->cotisationRepository = $cotisationRepository;
        $this->gestionScout = $gestionScout;
        $this->regionRepository = $regionRepository;
        $this->objectifRepository = $objectifRepository;
    }

    /**
     * @Route("/", name="backend_dashbord")
     */
    public function index(): Response
    {
        $annee = $this->gestionScout->cotisation();
        // Statistiques par branche
        $branches = [
            'meute' => "LOUVETEAU",
            'troupe' => "ECLAIREUR",
            'cheminot' => "CHEMINOT",
            'routier' => "ROUTIER"
        ];
        foreach ($branches as $item){
            $branche[$item] = count($this->scoutRepository->findByBranche('Jeune',$item,$annee));
        }

        // Statistiques par region
        $regionsListe = $this->regionRepository->findListDiocese();
        $nombre = []; $objectifs =[]; $regions = [];
        $i = 0;
        foreach ($regionsListe as $region){
            $scouts = $this->scoutRepository->findByRegion($region->getId(),$annee);
            $nombre[$i] = ['id'=>count($scouts)];
            $objectifs[$i] = ['val'=>$this->objectifRepository->findOneBy(['region'=>$region])->getValeur()];
            $pourcentage = count($scouts)/ $this->objectifRepository->findOneBy(['region'=>$region])->getValeur()*100;

            foreach ($branches as $item){
                $unite[$item] = count($this->scoutRepository->findByBranche('Jeune',$item,$annee,$region->getId()));
            }
            $regions[$i] = [
                'nom'=>$region->getNom(),
                'nombre'=>count($scouts),
                'pourcentage' => $pourcentage,
                'homme' => count($this->scoutRepository->findBySexe('HOMME',$annee,$region->getId())),
                'femme' => count($this->scoutRepository->findBySexe('FEMME',$annee,$region->getId())),
                'jeune' => count($this->scoutRepository->fingByStatut('Jeune',$annee,$region->getId())),
                'adulte' => count($this->scoutRepository->fingByStatut('Adulte',$annee,$region->getId())),
                'louveteau' => $unite['LOUVETEAU'],
                'eclaireur' => $unite['ECLAIREUR'],
                'cheminot'=> $unite['CHEMINOT'],
                'routier'=> $unite['ROUTIER']
            ];
            $i = $i +1;
        }

        // Statistique par sexe
        $sexe['total'] = count($this->scoutRepository->findBy(['cotisation'=>$annee]));
        $sexe['homme'] =  count($this->scoutRepository->findBySexe('HOMME',$annee));
        $sexe['femme'] = count($this->scoutRepository->findBySexe('FEMME',$annee));


        return $this->render('backend/index.html.twig',[
            'branche' => $branche,
            'regions' => $regions,
            'objectis' => $objectifs,
            'sexe' => $sexe,
        ]);
    }

    /**
     * @Route("/telemetrie", name="backend_courbe")
     */
    public function courbe()
    {
        $annee = $this->gestionScout->cotisation();
        $regions = $this->regionRepository->findListDiocese(); //dd($regions);
        $nombre = []; $objectifs =[]; $listes = [];
        $i = 0;
        foreach ($regions as $region){
            $scouts = $this->scoutRepository->findByRegion($region->getId(),$annee);
            $nombre[$i] = ['id'=>count($scouts)];
            $objectif = $this->objectifRepository->findOneBy(['region'=>$region])->getValeur();

            $objectifs[$i] = ['val'=>$objectif];
            $pourcentage = count($scouts)/ $objectif*100;
            $listes[$i] = ['region'=>$region->getNom(), 'nombre'=>count($scouts), 'pourcentage'=>$pourcentage,'objectif'=>$objectif];
            $i = $i +1;
        }
        //dd($nombre);
        return $this->render('backend/courbe.html.twig',[
            'annee' => $annee,
            'regions' => $regions,
            'nombre' => $nombre,
            'objectifs' => $objectifs,
            'listes' => $listes,
        ]);
    }

    /**
     * @Route("/liste-adherant/", name="backend_liste_adherant", methods={"GET"})
     */
    public function adherant()
    {
        $annee = $this->gestionScout->cotisation();
        $cotisations = $this->cotisationRepository->findBy(['annee'=>$annee]);
        $listes=[];
        $i = 0;
        foreach ($cotisations as $cotisation){
            $listes [$i] = [
                'region' => $cotisation->getScout()->getGroupe()->getDistrict()->getRegion()->getNom(),
                'statut' => $cotisation->getScout()->getStatut()->getLibelle(),
                'scoutNom' => $cotisation->getScout()->getNom(),
                'scoutPrenoms' => $cotisation->getScout()->getPrenoms(),
                'fonction' => $cotisation->getFonction(),
                'matricule' => $cotisation->getScout()->getMatricule(),
                'carte' => $cotisation->getCarte(),
                'montant' => $cotisation->getMontantSanFrais()
            ];
            $i = $i + 1;
        }
        //dd($listes);
        return $this->render('backend/adherant_liste.html.twig', [
            'annee' => $annee,
            //'cotisations' => $this->cotisationRepository->findBy(['annee'=>$annee]),
            'listes' => $listes
        ]);
    }
}
