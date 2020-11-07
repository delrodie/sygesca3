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
        //'cotisations' => $this->cotisationRepository->findBy(['annee'=>$annee]),
        return $this->render('backend/index.html.twig', [
            'annee' => $annee,
            'cotisations' => $this->cotisationRepository->findBy(['annee'=>$annee]),
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
            $objectifs[$i] = ['val'=>$this->objectifRepository->findOneBy(['region'=>$region])->getValeur()];
            $listes[$i] = ['region'=>$region->getNom(), 'nombre'=>count($scouts)];
            $i = $i +1;
        }
        //dd($nombre);
        return $this->render('backend/courbe.html.twig',[
            'annee' => $annee,
            'regions' => $regions,
            'nombre' => $nombre,
            'objectifs' => $objectifs,
            'listes' => $listes
        ]);
    }
}
