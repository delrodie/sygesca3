<?php

namespace App\Controller;

use App\Entity\District;
use App\Entity\Groupe;
use App\Entity\Scout;
use App\Utilities\GestionCotisation;
use App\Utilities\GestionScout;
use Cocur\Slugify\Slugify;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/superAdmin/restauration")
 */
class RestaurationController extends AbstractController
{

    private $gestionScout;

    public function __construct(GestionScout $gestionScout)
    {
        $this->gestionScout = $gestionScout;
    }
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
        $em = $this->getDoctrine()->getManager();
        $annee = $this->gestionScout->cotisation();
        $scouts = $this->getDoctrine()->getRepository(Scout::class)->findByFonction('district', $annee);
        $listes = []; $i=0;
        foreach ($scouts as $scout){
            //Recuperation du groupe du chef
            $groupe = $this->getDoctrine()->getRepository(Groupe::class)->findOneBy(['id'=>$scout->getGroupe()->getId()]);
            if (!strstr($groupe->getParoisse(), 'Equipe')) {
                // Si le groupe n'est pas une equipe de district lors affecter au groupe concerné
                $tampons = $this->getDoctrine()->getRepository(Groupe::class)->findEquipeDistrict($groupe->getDistrict()->getId());
                foreach ($tampons as $tampon){
                    $scout->setGroupe($tampon); //dd($scout);
                    $em->flush();
                }
            }
            $listes[$i++] = [
                'region' => $scout->getGroupe()->getDistrict()->getRegion()->getNom(),
                'district' => $scout->getGroupe()->getDistrict()->getNom(),
                'nom' => $scout->getNom(),
                'prenoms' => $scout->getPrenoms(),
                'sexe' => $scout->getSexe(),
                'fonction' => $scout->getFonction(),
                'contact' => $scout->getContact(),
                'carte' => $scout->getCarte(),
                'matricule' => $scout->getMatricule()
            ];
        }

        return $this->render('restauration/equipe.html.twig',[
            'listes' => $listes
        ]);
    }
}
