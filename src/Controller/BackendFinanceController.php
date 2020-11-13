<?php

namespace App\Controller;

use App\Repository\CotisationRepository;
use App\Repository\DistrictRepository;
use App\Repository\GroupeRepository;
use App\Repository\RegionRepository;
use App\Repository\ScoutRepository;
use App\Utilities\GestionRequete;
use App\Utilities\GestionScout;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function index(): Response
    {

        return $this->render('backend_finance/index.html.twig', [
            'listes' => $this->gestionRequete->liste_adherant(),
            'annee'=> $this->gestionScout->cotisation()
        ]);
    }

    /**
     * @Route("/ristourne", name="backend_finance_ristourne")
     */
    public function ristourne()
    {
        return $this->render('backend_finance/ristourne.html.twig',[
            'listes' => $this->gestionRequete->liste_adherant(true),
            'annee' => $this->gestionScout->cotisation()
        ]);
    }
}
