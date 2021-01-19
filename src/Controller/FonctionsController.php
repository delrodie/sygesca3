<?php

namespace App\Controller;

use App\Entity\Fonctions;
use App\Form\FonctionsType;
use App\Repository\FonctionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/fonctions")
 */
class FonctionsController extends AbstractController
{
    /**
     * @Route("/", name="admin_fonctions_index", methods={"GET"})
     */
    public function index(FonctionRepository $fonctionRepository): Response
    {
        return $this->render('fonctions/index.html.twig', [
            'fonctions' => $fonctionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_fonctions_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $fonction = new Fonctions();
        $form = $this->createForm(FonctionsType::class, $fonction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($fonction);
            $entityManager->flush();

            return $this->redirectToRoute('admin_fonctions_index');
        }

        return $this->render('fonctions/new.html.twig', [
            'fonction' => $fonction,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_fonctions_show", methods={"GET"})
     */
    public function show(Fonctions $fonction): Response
    {
        return $this->render('fonctions/show.html.twig', [
            'fonction' => $fonction,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_fonctions_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Fonctions $fonction): Response
    {
        $form = $this->createForm(FonctionsType::class, $fonction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_fonctions_index');
        }

        return $this->render('fonctions/edit.html.twig', [
            'fonction' => $fonction,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_fonctions_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Fonctions $fonction): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fonction->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($fonction);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_fonctions_index');
    }
}
