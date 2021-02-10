<?php


namespace App\Controller\Search;

use App\Entity\Region;
use App\Entity\Requete;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ReqController
 * @Route("/backend/req")
 */
class ReqController extends AbstractController
{
    CONST PAS_RESOLU = "PAS ENCORE RESOLU";
    CONST RESOLU = "RESOLU";
    CONST ATTENTE = "EN ATTENTE";

    /**
     * @Route("/{statut}", name="admin_requete_statut", methods={"GET"})
     */
    public function index(Request $request)
    {
        $statut = $request->get('statut');
        $region_req = $request->get('request_region');
        if (!$region_req)
            $requetes = $this->getDoctrine()->getRepository(Requete::class)->findByStatut($statut);
        else
            $requetes = $this->getDoctrine()->getRepository(Requete::class)->findByStatut($statut, $region_req);

        $listes = []; $i = 0; //dd($requetes);
        foreach ($requetes as $requete){
            if ($requete->getStatut() === self::RESOLU) $badge = "badge badge-success";
            elseif ($requete->getStatut() === self::ATTENTE) $badge = "badge badge-warning";
            else $badge = "badge badge-danger";

            $listes[$i++]=[
                'region' => $requete->getRegion()->getNom(),
                'nom' => $requete->getNom(),
                'prenoms' => $requete->getPrenoms(),
                'date_naissance' => $requete->getDatenaissance(),
                'lieu_naissance' => $requete->getLieunaissance(),
                'contact' => $requete->getContact(),
                'statut' => $requete->getStatut(),
                'badge' => $badge,
                'id' => $requete->getId(),
                'media' => $requete->getMedia(),
                'message' => $requete->getMessage(),
                'created_at' => $requete->getCreatedAt()
            ];
        }

        return $this->render('requete/statut.html.twig', [
            'listes' => $listes,
            'regions' => $this->getDoctrine()->getRepository(Region::class)->findAll(),
            'statut' => $statut
        ]);
    }
}