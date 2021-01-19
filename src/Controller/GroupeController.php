<?php

namespace App\Controller;

use App\Entity\Groupe;
use App\Form\GroupeType;
use App\Repository\GroupeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/groupe")
 */
class GroupeController extends AbstractController
{
    /**
     * @Route("/", name="admin_groupe_index", methods={"GET"})
     */
    public function index(GroupeRepository $groupeRepository): Response
    {
        $groupes = $groupeRepository->findList();
        $listes = []; $i =0;
        foreach ($groupes as $groupe){
            $listes[$i++] = [
                'region' => $groupe->getDistrict()->getRegion()->getNom(),
                'district' => $groupe->getDistrict()->getNom(),
                'groupe' => $groupe->getParoisse()
            ];
        } //dd($listes);
        return $this->render('groupe/index.html.twig', [
            'listes' => $listes,
        ]);
    }

    /**
     * @Route("/new", name="admin_groupe_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $groupe = new Groupe();
        $form = $this->createForm(GroupeType::class, $groupe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($groupe);
            $entityManager->flush();

            return $this->redirectToRoute('admin_groupe_index');
        }

        return $this->render('groupe/new.html.twig', [
            'groupe' => $groupe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_groupe_show", methods={"GET"})
     */
    public function show(Groupe $groupe): Response
    {
        return $this->render('groupe/show.html.twig', [
            'groupe' => $groupe,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_groupe_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Groupe $groupe): Response
    {
        $form = $this->createForm(GroupeType::class, $groupe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_groupe_index');
        }

        return $this->render('groupe/edit.html.twig', [
            'groupe' => $groupe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_groupe_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Groupe $groupe): Response
    {
        if ($this->isCsrfTokenValid('delete'.$groupe->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($groupe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_groupe_index');
    }
}
