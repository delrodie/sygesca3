<?php


namespace App\Controller\Search;

use App\Entity\Cotisation;
use App\Entity\Fonctions;
use App\Entity\Scout;
use App\Form\ScoutType;
use App\Utilities\GestionScout;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SearchController
 * @Route("/admin/search")
 */
class SearchController extends AbstractController
{
    private $gestionScout;

    public function __construct(GestionScout $gestionScout)
    {
        $this->gestionScout = $gestionScout;
    }

    /**
     * @Route("/", name="admin_search_index", methods={"GET"})
     */
    public function search(Request $request)
    {
        $search = $request->get('search_variable');
        $scouts = $this->getDoctrine()->getRepository(Scout::class)->findBySearch($search);

        $listes = []; $i=0; //dd($scouts);
        foreach ($scouts as $scout){
            $listes[$i++]=[
                'region' => $scout->getGroupe()->getDistrict()->getRegion()->getNom(),
                'district' => $scout->getGroupe()->getDistrict()->getNom(),
                'groupe' => $scout->getGroupe()->getParoisse(),
                'matricule' => $scout->getMatricule(),
                'nom' => $scout->getNom(),
                'prenoms' => $scout->getPrenoms(),
                'date_naissance' => $scout->getDatenaiss(),
                'lieu_naissance' => $scout->getLieunaiss(),
                'sexe' => $scout->getSexe(),
                'carte' => $scout->getCarte(),
                'fonction' => $scout->getFonction(),
                'cotisation' => $scout->getCotisation(),
                'slug' => $scout->getSlug(),
                'id_scout' => $scout->getId(),
                'statut' => $scout->getStatut()->getLibelle()
            ];
        }

        return $this->render('search/search_list.html.twig',[
            'listes' => $listes,
        ]);
    }

    /**
     * @Route("/{slug}", name="admin_search_show", methods={"GET","POST"})
     */
    public function show(Request $request, Scout $scout): Response
    {
        $form = $this->createForm(ScoutType::class, $scout);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $nv_fonction = $request->get('nouvelle_fonction');
            if ($nv_fonction){
                $fonction = $this->getDoctrine()->getRepository(Fonctions::class)->findOneBy(['id'=>$nv_fonction]);
                $ancienne_fonction = $scout->getFonction();
                $scout->setFonction($fonction->getLibelle());
            }else{
                $fonction = null;
            }
            //dd($fonction);
            $entityManager->flush();

            if ($fonction){
                $annee = $this->gestionScout->cotisation();
                $cotisation = $this->getDoctrine()->getRepository(Cotisation::class)->findOneBy(['scout'=>$scout->getId(), 'annee'=>$annee, 'carte'=>$scout->getCarte()]);
                if ($cotisation){
                    $cotisation->setFonction($fonction->getLibelle());
                    $entityManager->flush();
                }
            }

            return $this->redirectToRoute('recherche_carte_trouve', ['matricule'=>$scout->getMatricule()]);
        }

        return $this->render('search/search_show.html.twig',[
            'form' => $form->createView(),
            'scout' => $scout,
            'fonctions' => $this->getDoctrine()->getRepository(Fonctions::class)->findAll()
        ]);
    }
}