<?php

namespace App\Controller\Jeune;

use App\Entity\Cotisation;
use App\Entity\District;
use App\Entity\Groupe;
use App\Entity\Region;
use App\Utilities\GestionScout;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sygesca/jeune")
 */
class BrancheController extends AbstractController
{
    CONST louveteau = "LOUVETEAU (8 - 11 ANS)";
    CONST eclaireur = "ECLAIREUR (12 - 14 ANS)";
    CONST cheminot = "CHEMINOT (15 - 17 ANS)";
    CONST routier = "ROUTIER (18 - 21 ANS)";
    CONST statut = 2;

    private $gestionScout;

    public function __construct(GestionScout $gestionScout)
    {
        $this->gestionScout = $gestionScout;
    }

    /**
     * @Route("/", name="branche_generale")
     */
    public function index(): Response
    {
        $annee = $this->gestionScout->cotisation();
        $cotisations = $this->getDoctrine()->getRepository(Cotisation::class)->findJeuneByAnnee($annee);
        $listes=[];
        $i = 0;
        foreach ($cotisations as $cotisation){
            $listes [$i] = [
                'region' => $cotisation->getScout()->getGroupe()->getDistrict()->getRegion()->getNom(),
                //'statut' => $cotisation->getScout()->getStatut()->getLibelle(),
                'scoutNom' => $cotisation->getScout()->getNom(),
                'scoutPrenoms' => $cotisation->getScout()->getPrenoms(),
                'fonction' => $cotisation->getFonction(),
                'matricule' => $cotisation->getScout()->getMatricule(),
                'carte' => $cotisation->getCarte(),
                //'montant' => $cotisation->getMontantSanFrais()
            ];
            $i = $i + 1;
        }

        return $this->render('branche/index.html.twig', [
            'annee' => $annee,
            'listes' => $listes,
            'regions' => $this->getDoctrine()->getRepository(Region::class)->findBy([],['nom'=>"ASC"])
        ]);
    }

    /**
     * @Route("/{annee}", name="branche_region", methods={"GET"})
     */
    public function region(Request $request, $annee)
    {
        //$annee = $this->gestionScout->cotisation();
        $region = $request->get('branche_region');
        $cotisations = $this->getDoctrine()->getRepository(Cotisation::class)->findJeuneByAnnee($annee, $region);
        $listes=[];
        $i = 0;
        foreach ($cotisations as $cotisation){
            $listes [$i] = [
                'district' => $cotisation->getScout()->getGroupe()->getDistrict()->getNom(),
                //'statut' => $cotisation->getScout()->getStatut()->getLibelle(),
                'scoutNom' => $cotisation->getScout()->getNom(),
                'scoutPrenoms' => $cotisation->getScout()->getPrenoms(),
                'fonction' => $cotisation->getFonction(),
                'matricule' => $cotisation->getScout()->getMatricule(),
                'carte' => $cotisation->getCarte(),
                //'montant' => $cotisation->getMontantSanFrais()
            ];
            $i = $i + 1;
        }

        return $this->render('branche/region.html.twig', [
            'annee' => $annee,
            'listes' => $listes,
            'region' => $region,
            'regions' => $this->getDoctrine()->getRepository(Region::class)->findBy([],['nom'=>"ASC"]),
            'districts' => $this->getDoctrine()->getRepository(District::class)->findBy(['region'=>$region],['nom'=>"ASC"])
        ]);
    }

    /**
     * @Route("/{annee}/{region}", name="branche_district", methods={"GET"})
     */
    public function district(Request $request, $annee, $region)
    {
        $district = $request->get('branche_district');
        $cotisations = $this->getDoctrine()->getRepository(Cotisation::class)->findJeuneByAnnee($annee, $region, $district);
        $listes=[];
        $i = 0;
        foreach ($cotisations as $cotisation){
            $listes [$i] = [
                'groupe' => $cotisation->getScout()->getGroupe()->getParoisse(),
                //'statut' => $cotisation->getScout()->getStatut()->getLibelle(),
                'scoutNom' => $cotisation->getScout()->getNom(),
                'scoutPrenoms' => $cotisation->getScout()->getPrenoms(),
                'fonction' => $cotisation->getFonction(),
                'matricule' => $cotisation->getScout()->getMatricule(),
                'carte' => $cotisation->getCarte(),
                //'montant' => $cotisation->getMontantSanFrais()
            ];
            $i = $i + 1;
        }

        return $this->render('branche/district.html.twig', [
            'annee' => $annee,
            'listes' => $listes,
            'region' => $region,
            'district' => $district,
            'regions' => $this->getDoctrine()->getRepository(Region::class)->findBy([],['nom'=>"ASC"]),
            'districts' => $this->getDoctrine()->getRepository(District::class)->findBy(['region'=>$region],['nom'=>"ASC"]),
            'groupes' => $this->getDoctrine()->getRepository(Groupe::class)->findBy(['district'=>$district],['paroisse'=>"ASC"])
        ]);
    }
}
