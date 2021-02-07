<?php


namespace App\Controller;


use App\Entity\Requete;
use App\Form\ErreurType;
use App\Utilities\GestionMedia;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ErreurController
 * @Route("/requete")
 */
class ErreurController extends AbstractController
{
    CONST PAS_RESOLU = "PAS ENCORE RESOLU";
    CONST RESOLU = "RESOLU";
    CONST ATTENTE = "EN ATTENTE";

    private $gestionMedia;

    public function __construct(GestionMedia $gestionMedia)
    {
        $this->gestionMedia = $gestionMedia;
    }

    /**
     * @Route("/new", name="user_requete_new", methods={"GET","POST"})
     */
    public function index(Request $request): Response
    {
        $requete = new Requete();
        $form = $this->createForm(ErreurType::class, $requete);
        $form->handleRequest($request);

        $message = [];

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager(); //dd($requete);

            $variables = [
                'nom' => $requete->getNom(),
                'prenoms' => $requete->getPrenoms(),
                'date' => $requete->getDatenaissance(),
                'lieu' => $requete->getLieunaissance()
            ];

            $verifExist = $this->getDoctrine()->getRepository(Requete::class)->findOneBy([
                'nom' => $variables['nom'],
                'prenoms' => $variables['prenoms'],
                'datenaissance' => $variables['date'],
                'lieunaissance' => $variables['lieu']
            ]);

            if ($verifExist){
                $message = [
                    'statut' => 'error',
                    'titre' => "Echec!",
                    'texte' => "Echec! Votre requête a déjà été envoyée aux administrateurs."
                ];

                return $this->render("erreur/index.html.twig",[
                    'requete' => $requete,
                    'form' => $form->createView(),
                    'message' => $message,
                ]);

            }

            // Gestion des medias
            $mediaFile = $form->get('media')->getData();

            if ($mediaFile){
                $media = $this->gestionMedia->upload($mediaFile, 'erreur');

                $requete->setMedia($media);
            }else{
                $message = [
                    'statut' => "warning",
                    'titre' => "Attention!",
                    'texte' => "Veuillez joindre le recu cinetpay ou le message de confirmation de votre opérateur mobile."
                ];

                return $this->render("erreur/index.html.twig",[
                    'requete' => $requete,
                    'form' => $form->createView(),
                    'message' => $message,
                ]);
            }
            //dd($slide);
            $requete->setStatut(self::PAS_RESOLU);

            $entityManager->persist($requete);
            $entityManager->flush();

            $message = [
                'statut' => 'success',
                'titre' => "Félicitations!",
                'texte' => "Votre requête vient d'être envoyée aux administrateurs. Vous serez contacté(e) sous peu."
            ];

            return $this->render("erreur/index.html.twig",[
                'requete' => $requete,
                'form' => $form->createView(),
                'message' => $message,
                'notif' => true,
            ]);
        }


        return $this->render("erreur/index.html.twig",[
            'requete' => $requete,
            'form' => $form->createView(),
            'message' => $message,
            'notif' => true,
            'icon' => 'success'
        ]);
    }
}