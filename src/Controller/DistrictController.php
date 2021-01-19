<?php

namespace App\Controller;

use App\Entity\District;
use App\Entity\Groupe;
use App\Form\DistrictType;
use App\Repository\DistrictRepository;
use Cocur\Slugify\Slugify;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/district")
 */
class DistrictController extends AbstractController
{
    /**
     * @Route("/", name="admin_district_index", methods={"GET"})
     */
    public function index(DistrictRepository $districtRepository): Response
    {
        $listes = $districtRepository->findList();
        if (!$listes)
            $districts = [
                'region' => null,
                'nom' => null,
                'slug' => 0,
                'groupe' => null
            ];
        else{
            $i = 0;
            foreach ($listes as $liste){
                $nombre_groupe = count($this->getDoctrine()->getRepository(Groupe::class)->findByDistrict($liste->getSlug()));
                $districts[$i++] = [
                    'region' => $liste->getRegion()->getNom(),
                    'nom' => $liste->getNom(),
                    'slug' => $liste->getSlug(),
                    'groupe' => $nombre_groupe
                ];
            }
        }

        return $this->render('district/index.html.twig', [
            'districts' => $districts,
        ]);
    }

    /**
     * @Route("/new", name="admin_district_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $district = new District();
        $form = $this->createForm(DistrictType::class, $district);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $slugify = new Slugify();
            $slug =  $slugify->slugify($district->getNom());

            $district->setSlug($slug);

            $entityManager->persist($district);
            $entityManager->flush();

            $this->addFlash('success', "Le district a été ajouté avec succès!");

            return $this->redirectToRoute('admin_district_index');
        }

        return $this->render('district/new.html.twig', [
            'district' => $district,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="admin_district_show", methods={"GET"})
     */
    public function show(District $district): Response
    {
        $groupes = $this->getDoctrine()->getRepository(Groupe::class)->findByDistrict($district->getSlug());
        if (!$groupes){
            $listes = [];
        }else{
            $i = 0;
            foreach ($groupes as $groupe){
                $listes[$i++] = [
                    'district' => $groupe->getDistrict()->getNom(),
                    'nom' => $groupe->getParoisse(),
                    'localite' => $groupe->getLocalite()
                ];
            }
        }
        return $this->render('district/show.html.twig', [
            'district' => $district,
            'listes' => $listes
        ]);

    }

    /**
     * @Route("/{slug}/edit", name="admin_district_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, District $district): Response
    {
        $form = $this->createForm(DistrictType::class, $district);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_district_index');
        }

        return $this->render('district/edit.html.twig', [
            'district' => $district,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_district_delete", methods={"DELETE"})
     */
    public function delete(Request $request, District $district): Response
    {
        if ($this->isCsrfTokenValid('delete'.$district->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($district);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_district_index');
    }
}
