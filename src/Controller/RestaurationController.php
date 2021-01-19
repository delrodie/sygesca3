<?php

namespace App\Controller;

use App\Entity\District;
use App\Entity\Groupe;
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
        $districts = $this->getDoctrine()->getRepository(District::class)->findAll();
        foreach ($districts as $district){
            $groupes  =  $this->getDoctrine()->getRepository(Groupe::class)->findEquipeDistrict($district->getId());
            if ($groupes){
                dd($groupes);
            } 
        }

        return $this->render('restauration/index.html.twig', [
            'controller_name' => 'RestaurationController',
        ]);
    }
}
