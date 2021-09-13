<?php

namespace App\Controller;

use App\Utilities\GestionRequete;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/backend/ristourne")
 */
class BackendRistourneController extends AbstractController
{
    private $gestionRequete;

    public function __construct(GestionRequete $gestionRequete)
    {
        $this->gestionRequete = $gestionRequete;
    }
    /**
     * @Route("/", name="backend_ristourne_index", methods={"GET","POST"})
     */
    public function index()
    {
        return $this->render('backend_ristourne/index.html.twig',[]);
    }

    /**
     * @Route("/ajax", name="backend_ristourne_ajax")
     */
    public function ajax(): Response
    {
        //Initialisation
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $listes = $this->gestionRequete->liste_adherant(); //dd($this->json($listes));

        return $data = $this->json($listes);
    }
}
