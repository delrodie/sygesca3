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
    const VALID = "VALID";
    const UNKNOW = "UNKNOW";

    /**
     * @Route("/", name="backend_user_paiement", methods={"GET","POST"})
     */
    public function index(Request $request): Response
    {
        $region_request = $request->get('request_region');
        $district_request = $request->get('request_district'); //dd($region_request);
        $groupe_request = $request->get('request_groupe'); //dd($region_request);
        if ($region_request){
            $paiements = $this->getDoctrine()->getRepository(UserInfo2020::class)->findList(self::VALID, $region_request);
        }elseif ($district_request){
            $paiements = $this->getDoctrine()->getRepository(UserInfo2020::class)->findList(self::VALID, null,$district_request);
        }elseif ($groupe_request){
            $paiements = $this->getDoctrine()->getRepository(UserInfo2020::class)->findList(self::VALID, null,null,$groupe_request);
        }
        else{
            $paiements = $this->getDoctrine()->getRepository(UserInfo2020::class)->findList(self::VALID);
        } //dd($paiements);

        $listes=[]; $i=0;
        foreach ($paiements as $paiement){
            if ($paiement->getRegion()) $var_region = $paiement->getRegion()->getNom(); else $var_region = null;
            if ($paiement->getDistrict()) $var_district = $paiement->getDistrict()->getNom(); else $var_district = null;
            if ($paiement->getGroupe()) $var_groupe = $paiement->getGroupe()->getParoisse(); else $var_groupe = null;
            $listes[$i++]=[
                'region' => $var_region,
                'district' => $var_district,
                'groupe' => $var_groupe,
                'fonction' => $paiement->getFonction()->getLibelle(),
                'nom' => $paiement->getNom(),
                'prenoms' => $paiement->getPrenoms(),
                'date_naissance' => $paiement->getDatenaissance(),
                'lieu_naissance' => $paiement->getLieuNaissance(),
                'sexe' => $paiement->getSexe(),
                'contact' => $paiement->getContact(),
                'id_transaction' => $paiement->getIdTransaction(),
                'status_paiement' => $paiement->getStatusPaiement(),
                'statut' => $paiement->getStatut(),
                'matricule' => $paiement->getMatricule()
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

    /**
     * @Route("/invalid", name="backend_user_paiement_unknow", methods={"GET","POST"})
     */
    public function unknow(Request $request): Response
    {
        $region_request = $request->get('request_region');
        $district_request = $request->get('request_district'); //dd($region_request);
        $groupe_request = $request->get('request_groupe'); //dd($region_request);
        if ($region_request){
            $paiements = $this->getDoctrine()->getRepository(UserInfo2020::class)->findList(self::UNKNOW, $region_request);
        }elseif ($district_request){
            $paiements = $this->getDoctrine()->getRepository(UserInfo2020::class)->findList(self::UNKNOW, null,$district_request);
        }elseif ($groupe_request){
            $paiements = $this->getDoctrine()->getRepository(UserInfo2020::class)->findList(self::UNKNOW, null,null,$groupe_request);
        }
        else{
            $paiements = $this->getDoctrine()->getRepository(UserInfo2020::class)->findList(self::UNKNOW);
        } //dd($paiements);

        $listes=[]; $i=0;
        foreach ($paiements as $paiement){
            if ($paiement->getRegion()) $var_region = $paiement->getRegion()->getNom(); else $var_region = null;
            if ($paiement->getDistrict()) $var_district = $paiement->getDistrict()->getNom(); else $var_district = null;
            if ($paiement->getGroupe()) $var_groupe = $paiement->getGroupe()->getParoisse(); else $var_groupe = null;
            if ($paiement->getFonction()) $var_fonction = $paiement->getFonction()->getLibelle(); else $var_fonction = null;
            $listes[$i++]=[
                'region' => $var_region,
                'district' => $var_district,
                'groupe' => $var_groupe,
                'fonction' => $var_fonction,
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
            $html =  $this->render('paiement/district_invalid.html.twig', [
                'listes' => $listes,
                'regions' => $this->getDoctrine()->getRepository(Region::class)->findAll(),
                'districts' => $this->getDoctrine()->getRepository(District::class)->findBy(['region'=>$district->getRegion()->getId()]),
                'groupes' => $this->getDoctrine()->getRepository(Groupe::class)->findBy(['district'=>$district_request]),
                'district' => $district
            ]);
        }elseif($groupe_request){
            $groupe = $this->getDoctrine()->getRepository(Groupe::class)->findByID($groupe_request); //dd($groupe);
            $html =  $this->render('paiement/groupe_invalid.html.twig', [
                'listes' => $listes,
                'regions' => $this->getDoctrine()->getRepository(Region::class)->findAll(),
                'districts' => $this->getDoctrine()->getRepository(District::class)->findBy(['region'=>$groupe->getDistrict()->getRegion()->getId()]),
                'groupes' => $this->getDoctrine()->getRepository(Groupe::class)->findBy(['district'=>$groupe->getDistrict()->getId()]),
                'groupe' => $groupe
            ]);
        }else{
            $html =  $this->render('paiement/index_invalid.html.twig', [
                'listes' => $listes,
                'regions' => $this->getDoctrine()->getRepository(Region::class)->findAll()
            ]);
        }


        return $html;
    }
}
