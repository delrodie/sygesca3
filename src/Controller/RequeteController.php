<?php

namespace App\Controller;

use App\Entity\Region;
use App\Entity\Requete;
use App\Form\RequeteType;
use App\Repository\RequeteRepository;
use App\Utilities\Notification;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sygesca/requete")
 */
class RequeteController extends AbstractController
{
    CONST PAS_RESOLU = "PAS_RESOLU";
    CONST RESOLU = "RESOLU";
    CONST ATTENTE = "ATTENTE";

    private $notification;

    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    /**
     * @Route("/", name="admin_requete_index", methods={"GET"})
     */
    public function index(Request $request, RequeteRepository $requeteRepository): Response
    {
        $region_req = $request->get('request_region');
        if (!$region_req)
            $requetes = $requeteRepository->findByStatut(self::PAS_RESOLU);
        else
            $requetes = $requeteRepository->findByStatut(self::PAS_RESOLU, $region_req);

        $listes = []; $i = 0; //dd($requetes);
        foreach ($requetes as $requete){
            if ($requete->getStatut() === self::RESOLU) $badge = "badge badge-success";
            elseif ($requete->getStatut() === self::ATTENTE) $badge = "badge badge-warning";
            else $badge = "badge badge-danger";

            $listes[$i++]=[
                'region' => $requete->getRegion()->getNom(),
                'nom' => $requete->getNom(),
                'prenoms' => $requete->getPrenoms(),
                'date_naissance' => $requete->getDatenaissance(),
                'lieu_naissance' => $requete->getLieunaissance(),
                'contact' => $requete->getContact(),
                'statut' => $requete->getStatut(),
                'badge' => $badge,
                'id' => $requete->getId(),
                'media' => $requete->getMedia(),
                'message' => $requete->getMessage(),
                'created_at' => $requete->getCreatedAt()
            ];
        }

        return $this->render('requete/index.html.twig', [
            'listes' => $listes,
            'regions' => $this->getDoctrine()->getRepository(Region::class)->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_requete_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $requete = new Requete();
        $form = $this->createForm(RequeteType::class, $requete);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($requete);
            $entityManager->flush();

            return $this->redirectToRoute('admin_requete_index');
        }

        return $this->render('requete/new.html.twig', [
            'requete' => $requete,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_requete_show", methods={"GET"})
     */
    public function show(Requete $requete): Response
    {
        return $this->render('requete/show.html.twig', [
            'requete' => $requete,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_requete_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Requete $requete): Response
    {
        $form = $this->createForm(RequeteType::class, $requete);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $message = $request->get('sms_contenu');
            $phone = "225".$requete->getContact();
            if ($message){
                $sms = $this->notification->sms($phone, $message);
                $this->addFlash('warning', $sms);
            }

            return $this->redirectToRoute('admin_requete_index');
        }

        return $this->render('requete/edit.html.twig', [
            'requete' => $requete,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_requete_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Requete $requete): Response
    {
        if ($this->isCsrfTokenValid('delete'.$requete->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($requete);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_requete_index');
    }
}
