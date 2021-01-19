<?php

namespace App\Controller;

use App\Entity\District;
use App\Entity\Groupe;
use Cocur\Slugify\Slugify;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/superAdmin/restauration")
 */
class RestaurationController extends AbstractController
{
    /**
     * @Route("/", name="superadmin_restauration_district")
     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $slugify = new Slugify();
        $districts = $this->getDoctrine()->getRepository(District::class)->findAll();
        foreach ($districts as $district){
            $groupes  =  $this->getDoctrine()->getRepository(Groupe::class)->findEquipeDistrict($district->getId());
            if (!$groupes){
                $paroisse = "Equipe de district ".ucwords(strtolower($district->getNom()));
                $groupe = new Groupe();
                $groupe->setDistrict($district);
                $groupe->setParoisse($paroisse);
                $groupe->setLocalite($district->getNom());
                $groupe->setSlug($slugify->slugify($paroisse));
                $groupe->setPubliePar("automatique");

                $em->persist($groupe);
                $em->flush();
            }
        }
        $groups = $this->getDoctrine()->getRepository(Groupe::class)->findEquipeDistrict();
        $listes=[]; $i = 0;
        foreach ($groups as $group){
            $listes[$i++] = [
                'region' => $group->getDistrict()->getRegion()->getNom(),
                'district' => $group->getDistrict()->getNom(),
                'groupe' => $group->getParoisse()
            ];
        }

        return $this->render('restauration/index.html.twig', [
            'listes' => $listes,
        ]);
    }
    
    /**
     * @Route("/equipe", name="superadmin_restauration_equipe")
     */
    public function equipe()
    {

    }
}
