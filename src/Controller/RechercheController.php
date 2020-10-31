<?php

namespace App\Controller;

use App\Entity\Recherche;
use App\Entity\Scout;
use App\Form\RechercheCarteType;
use App\Form\RechercheCivileType;
use App\Form\RechercheMatriculeType;
use App\Repository\ScoutRepository;
use App\Utilities\GestionCotisation;
use App\Utilities\GestionScout;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class RechercheController
 * @Route("/recherche")
 */
class RechercheController extends AbstractController
{
    private $scoutRepository;
    private $gestionScout;

    public function __construct(ScoutRepository $scoutRepository, GestionScout $gestionScout)
    {
        $this->scoutRepository = $scoutRepository;
        $this->gestionScout = $gestionScout;
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
                //dd($scout);
                //Renvoyer au formulaire de remmplissage
                return $this->redirectToRoute('adhesion_ancien',['slug'=>$scout->getSlug()]);
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
                return $this->redirectToRoute('adhesion_ancien',['slug'=> $scout->getSlug()]);
            }
        }
        return $this->render('recherche/civile.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/carte/", name="recherche_carte", methods={"GET","POST"})
     */
    public function carte(Request $request)
    {
        //Initialisation
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $recherche = new Recherche();
        $form = $this->createForm(RechercheCarteType::class, $recherche);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $scout = $this->scoutRepository->findOneBy([
                'nom' => $recherche->getNom(),
                'prenoms'=> $recherche->getPrenoms(),
                'datenaiss' => $recherche->getDateNaissance(),
                'cotisation' => $this->gestionScout->cotisation()
            ]);

            if (!$scout){
                $message=[
                    'type' => 'error',
                ];

                return $this->json($message);
            }
            $message=[
                'type' => 'success',
                'matricule'=> $scout->getMatricule(),
            ];

            return $this->json($message);

        }

        return $this->render("recherche/recherche_carte.html.twig",[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/carte/{matricule}", name="recherche_carte_trouve", methods={"GET","POST"})
     */
    public function trouve(Scout $scout)
    {
        return $this->render("recherche/carte.html.twig",[
            'scout'=> $scout
        ]);
    }
}
