<?php

namespace App\Controller;

use App\Entity\District;
use App\Entity\Groupe;
use App\Entity\Region;
use App\Entity\UserInfo2020;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/backend/paiement")
 */
class PaiementController extends AbstractController
{
    /**
     * @Route("/", name="backend_user_paiement", methods={"GET","POST"})
     */
    public function index(Request $request): Response
    {
        $region_request = $request->get('request_region');
        $district_request = $request->get('request_district'); //dd($region_request);
        $groupe_request = $request->get('request_groupe'); //dd($region_request);
        if ($region_request){
            $paiements = $this->getDoctrine()->getRepository(UserInfo2020::class)->findList($region_request);
        }elseif ($district_request){
            $paiements = $this->getDoctrine()->getRepository(UserInfo2020::class)->findList(null,$district_request);
        }elseif ($groupe_request){
            $paiements = $this->getDoctrine()->getRepository(UserInfo2020::class)->findList(null,null,$groupe_request);
        }
        else{
            $paiements = $this->getDoctrine()->getRepository(UserInfo2020::class)->findList();
        } dd($paiements);

        $listes=[]; $i=0;
        foreach ($paiements as $paiement){
            $listes[$i++]=[
                'region' => $paiement->getRegion()->getNom(),
                'district' => $paiement->getDistrict()->getNom(),
                'groupe' => $paiement->getGroupe()->getParoisse(),
                'fonction' => $paiement->getFonction()->getLibelle(),
                'nom' => $paiement->getNom(),
                'prenoms' => $paiement->getPrenoms(),
                'date_naissance' => $paiement->getDatenaissance(),
                'lieu_naissance' => $paiement->getLieuNaissance(),
                'sexe' => $paiement->getSexe(),
                'contact' => $paiement->getContact(),
                'id_transaction' => $paiement->getIdTransaction(),
                'status_paiement' => $paiement->getStatusPaiement(),
                'statut' => $paiement->getStatut()
            ];
        } //dd($listes);

        if ($region_request){

            $html =  $this->render('paiement/region.html.twig', [
                'listes' => $listes,
                'regions' => $this->getDoctrine()->getRepository(Region::class)->findAll(),
                'districts' => $this->getDoctrine()->getRepository(District::class)->findBy(['region'=>$region_request]),
                'region' => $this->getDoctrine()->getRepository(Region::class)->findOneBy(['id'=>$region_request]),
            ]);
        }elseif($district_request){
            $district = $this->getDoctrine()->getRepository(District::class)->findOneBy(['id'=>$district_request]);
            $html =  $this->render('paiement/district.html.twig', [
                'listes' => $listes,
                'regions' => $this->getDoctrine()->getRepository(Region::class)->findAll(),
                'districts' => $this->getDoctrine()->getRepository(District::class)->findBy(['region'=>$district->getRegion()->getId()]),
                'groupes' => $this->getDoctrine()->getRepository(Groupe::class)->findBy(['district'=>$district_request]),
                'district' => $district
            ]);
        }elseif($groupe_request){
            $groupe = $this->getDoctrine()->getRepository(Groupe::class)->findByID($groupe_request); //dd($groupe);
            $html =  $this->render('paiement/groupe.html.twig', [
                'listes' => $listes,
                'regions' => $this->getDoctrine()->getRepository(Region::class)->findAll(),
                'districts' => $this->getDoctrine()->getRepository(District::class)->findBy(['region'=>$groupe->getDistrict()->getRegion()->getId()]),
                'groupes' => $this->getDoctrine()->getRepository(Groupe::class)->findBy(['district'=>$groupe->getDistrict()->getId()]),
                'groupe' => $groupe
            ]);
        }else{
            $html =  $this->render('paiement/index.html.twig', [
                'listes' => $listes,
                'regions' => $this->getDoctrine()->getRepository(Region::class)->findAll()
            ]);
        }


        return $html;
    }
}
