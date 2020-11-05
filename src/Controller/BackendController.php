<?php

namespace App\Controller;

use App\Repository\CotisationRepository;
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

    public function __construct(ScoutRepository $scoutRepository, CotisationRepository $cotisationRepository, GestionScout $gestionScout)
    {
        $this->scoutRepository = $scoutRepository;
        $this->cotisationRepository = $cotisationRepository;
        $this->gestionScout = $gestionScout;
    }

    /**
     * @Route("/", name="backend_dashbord")
     */
    public function index(): Response
    {
        return $this->render('backend/index.html.twig', [
            'cotisations' => $this->cotisationRepository->findBy(['annee'=>$this->gestionScout->cotisation()]),
        ]);
    }
}
