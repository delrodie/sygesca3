<?php

namespace App\Controller;

use App\Entity\Region;
use App\Repository\CotisationRepository;
use App\Repository\DistrictRepository;
use App\Repository\GroupeRepository;
use App\Repository\RegionRepository;
use App\Repository\ScoutRepository;
use App\Utilities\GestionRequete;
use App\Utilities\GestionScout;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BackendFinanceController
 * @Route("/backend/finance")
 */
class BackendFinanceController extends AbstractController
{
    private $gestionRequete;
    private $gestionScout;

    public function __construct(GestionRequete $gestionRequete, GestionScout $gestionScout)
    {
        $this->gestionRequete = $gestionRequete;
        $this->gestionScout = $gestionScout;
    }
    /**
     * @Route("/", name="backend_finance_index")
     */
    public function index(Request $request): Response
    {
        $req_region = $request->get('finance_region');
        if ($req_region) $structure = $req_region;
        else $structure = 1;

        return $this->render('backend_finance/index.html.twig', [
            'listes' => $this->gestionRequete->liste_adherant($structure),
            'annee'=> $this->gestionScout->cotisation(),
            'regions' => $this->getDoctrine()->getRepository(Region::class)->findAll(),
        ]);
    }

    /**
     * @Route("/ristourne", name="backend_finance_ristourne")
     */
    public function ristourne(Request $request)
    {
        $req_region = $request->get('finance_region');
        if ($req_region) $structure = $req_region;
        else $structure = 4;

        return $this->render('backend_finance/ristourne.html.twig',[
            'listes' => $this->gestionRequete->liste_adherant($structure, true),
            'annee' => $this->gestionScout->cotisation(),
            'regions' => $this->getDoctrine()->getRepository(Region::class)->findListDiocese()
        ]);
    }
}
