<?php

namespace App\Controller;

use App\Entity\Recherche;
use App\Form\RechercheCivileType;
use App\Form\RechercheMatriculeType;
use App\Repository\ScoutRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RechercheController
 * @Route("/recherche")
 */
class RechercheController extends AbstractController
{
    private $scoutRepository;

    public function __construct(ScoutRepository $scoutRepository)
    {
        $this->scoutRepository = $scoutRepository;
    }

    /**
     * @Route("/", name="inscription_recherche_matricule", methods={"GET","POST"})
     */
    public function index(Request $request): Response
    {
        $recherche = new Recherche();
        $form = $this->createForm(RechercheMatriculeType::class, $recherche);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $matricule = $recherche->getMatricule();

            $scout = $this->scoutRepository->findOneBy(['matricule'=>$matricule]); //dd($scout);
            if (!$scout){
                $this->addFlash('error', "Votre matricule n'a pas été trouvé. Veuillez vérifier votre saisie ou faites votre recherche par votre identité civile.");
                return $this->redirectToRoute('inscription_recherche_matricule');
            }else{
                dd($scout);
                //Renvoyer au formulaire de remmplissage
                return $this->redirectToRoute('app_accueil');
            }
        }
        return $this->render('recherche/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/identite", name="inscription_recherche_civile", methods={"GET","POST"})
     */
    public function civile(Request $request)
    {
        $recherche = new Recherche();
        $form = $this->createForm(RechercheCivileType::class, $recherche);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){ //dd($recherche);
            $scout = $this->scoutRepository->findOneBy([
                'nom' => $recherche->getNom(),
                'prenoms' => $recherche->getPrenoms(),
                'datenaiss' => $recherche->getDateNaissance(),
                'lieunaiss' => $recherche->getLieuNaissance()
            ]);

            if (!$scout){
                $this->addFlash('error', "Votre identité n'a pas été trouvée. Veuillez vérifier vote saisie ou faites votre recherche par le matricule.");
                return $this->redirectToRoute('inscription_recherche_civile');
            }else{
                dd($scout);
            }
        }
        return $this->render('recherche/civile.html.twig',[
            'form' => $form->createView()
        ]);
    }
}
