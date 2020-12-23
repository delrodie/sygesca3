<?php

namespace App\Controller;

use App\Entity\Cotisation;
use App\Entity\District;
use App\Entity\Groupe;
use App\Entity\Region;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ArchiveController
 * @Route("/archive")
 */
class ArchiveController extends AbstractController
{
    /**
     * @Route("/{annee}", name="archive_index", methods={"GET"})
     */
    public function index(Request $request, $annee): Response
    {
        $cotisations = $this->getDoctrine()->getRepository(Cotisation::class)->findByAnnee($annee);
        $listes=[];
        $i = 0;
        foreach ($cotisations as $cotisation){
            $listes [$i] = [
                'region' => $cotisation->getScout()->getGroupe()->getDistrict()->getRegion()->getNom(),
                'district' => $cotisation->getScout()->getGroupe()->getDistrict()->getNom(),
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

        return $this->render('archive/index.html.twig', [
            'annee' => $annee,
            //'cotisations' => $this->cotisationRepository->findBy(['annee'=>$annee]),
            'listes' => $listes,
            'regions' => $this->getDoctrine()->getRepository(Region::class)->findBy([],['nom'=>"ASC"])
        ]);
    }

    /**
     * @Route("/{annee}/region", name="archive_region", methods={"GET"})
     */
    public function region(Request $request, $annee)
    {
        $region = $request->get('archive_region');
        $cotisations = $this->getDoctrine()->getRepository(Cotisation::class)->findByAnnee($annee, $region);
        $listes=[];
        $i = 0;
        foreach ($cotisations as $cotisation){
            $listes [$i] = [
                'district' => $cotisation->getScout()->getGroupe()->getDistrict()->getNom(),
                'groupe' => $cotisation->getScout()->getGroupe()->getParoisse(),
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

        return $this->render('archive/region.html.twig', [
            'annee' => $annee,
            //'cotisations' => $this->cotisationRepository->findBy(['annee'=>$annee]),
            'listes' => $listes,
            'region' => $this->getDoctrine()->getRepository(Region::class)->findOneBy(['id'=>$region]),
            'districts' => $this->getDoctrine()->getRepository(District::class)->findBy(['region'=>$region],['nom'=>"ASC"]),
            'regions' => $this->getDoctrine()->getRepository(Region::class)->findBy([],['nom'=>"ASC"])
        ]);
    }

    /**
     * @Route("/{annee}/{region}/district", name="archive_district", methods={"GET"})
     */
    public function district(Request $request, $annee, $region)
    {
        $district = $request->get('archive_district');
        $cotisations = $this->getDoctrine()->getRepository(Cotisation::class)->findByAnnee($annee, null, $district);
        $listes=[];
        $i = 0;
        foreach ($cotisations as $cotisation){
            $listes [$i] = [
                'district' => $cotisation->getScout()->getGroupe()->getDistrict()->getNom(),
                'groupe' => $cotisation->getScout()->getGroupe()->getParoisse(),
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

        return $this->render('archive/district.html.twig', [
            'annee' => $annee,
            //'cotisations' => $this->cotisationRepository->findBy(['annee'=>$annee]),
            'listes' => $listes,
            'region' => $this->getDoctrine()->getRepository(Region::class)->findOneBy(['id'=>$region]),
            'districts' => $this->getDoctrine()->getRepository(District::class)->findBy(['region'=>$region],['nom'=>"ASC"]),
            'district' => $this->getDoctrine()->getRepository(District::class)->findOneBy(['id'=>$district]),
            'groupes' => $this->getDoctrine()->getRepository(Groupe::class)->findBy(['district'=>$district])
        ]);
    }

    /**
     * @Route("/{annee}/{region}/{district}/groupe", name="archive_groupe", methods={"GET"})
     */
    public function groupe(Request $request, $annee, $region, $district)
    {
        $groupe = $request->get('archive_groupe');
        $cotisations = $this->getDoctrine()->getRepository(Cotisation::class)->findByAnnee($annee, null, null, $groupe);
        $listes=[];
        $i = 0;
        foreach ($cotisations as $cotisation){
            $listes [$i] = [
                'district' => $cotisation->getScout()->getGroupe()->getDistrict()->getNom(),
                'groupe' => $cotisation->getScout()->getGroupe()->getParoisse(),
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

        $groupeEntity = $this->getDoctrine()->getRepository(Groupe::class)->findOneBy(['id'=>$groupe]);

        return $this->render('archive/groupe.html.twig', [
            'annee' => $annee,
            //'cotisations' => $this->cotisationRepository->findBy(['annee'=>$annee]),
            'listes' => $listes,
            'region' => $this->getDoctrine()->getRepository(Region::class)->findOneBy(['id'=>$region]),
            'districts' => $this->getDoctrine()->getRepository(District::class)->findBy(['region'=>$region],['nom'=>"ASC"]),
            'district' => $this->getDoctrine()->getRepository(District::class)->findOneBy(['id'=>$groupeEntity->getDistrict()->getId()]),
            'groupes' => $this->getDoctrine()->getRepository(Groupe::class)->findBy(['district'=>$groupeEntity->getDistrict()->getId()]),
            'groupe' => $groupeEntity
        ]);
    }
}
