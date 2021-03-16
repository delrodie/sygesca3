<?php

namespace App\Controller\Genre;

use App\Entity\District;
use App\Entity\Region;
use App\Entity\Scout;
use App\Entity\Statut;
use App\Utilities\GestionScout;
use phpDocumentor\Reflection\Types\Self_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sygesca/genre")
 */
class GenreController extends AbstractController
{
    CONST HOMME = "HOMME";
    CONST FEMME = "FEMME";
    CONST JEUNE = "Jeune";
    CONST ADULTE = "Adulte";
    CONST M = "M";
    CONST F = "F";

    private $gestionScout;

    public function __construct(GestionScout $gestionScout)
    {
        $this->gestionScout = $gestionScout;
    }

    /**
     * @Route("/", name="genre_general", methods={"GET"})
     */
    public function index(): Response
    {
        $annee = $this->gestionScout->cotisation(); //dd($annee);
        $regions = $this->getDoctrine()->getRepository(Region::class)->findAll();

        $homme = 0; $femme = 0; $garcon = 0; $fille = 0; $genres = []; $i=0;
        foreach ($regions as $region){
            $nombre = count($this->getDoctrine()->getRepository(Scout::class)->findByRegion($region->getId(), $annee));
            $statuts = $this->getDoctrine()->getRepository(Statut::class)->findAll();
            foreach ($statuts as $statut){
                if ($statut->getLibelle() === self::JEUNE){
                    $garcon = count($this->getDoctrine()->getRepository(Scout::class)->findByGenre($region->getId(),$statut->getId(), self::HOMME,$annee, self::M));
                    $fille = count($this->getDoctrine()->getRepository(Scout::class)->findByGenre($region->getId(),$statut->getId(), self::FEMME,$annee, self::F));
                }else{
                    $homme = count($this->getDoctrine()->getRepository(Scout::class)->findByGenre($region->getId(),$statut->getId(), self::HOMME,$annee, self::M));
                    $femme = count($this->getDoctrine()->getRepository(Scout::class)->findByGenre($region->getId(),$statut->getId(), self::FEMME,$annee, self::F));
                }
            }
            $genres[$i++] = [
                'region' => $region->getNom(),
                'homme' => $homme,
                'femme' => $femme,
                'garcon' => $garcon,
                'fille' => $fille,
                'total' => $nombre
            ];
        }

        return $this->render('backend/genre.html.twig',[
            'genres' => $genres,
            'regions' => $regions,
            'annee' => $annee
        ]);
    }

    /**
     * @Route("/{annee}", name="genre_region", methods={"GET","POST"})
     */
    public function region(Request $request): Response
    {
        $annee = $this->gestionScout->cotisation(); //dd($annee);
        $regions = $this->getDoctrine()->getRepository(Region::class)->findAll();
        $req_region = $request->get('genre_region');
        $region = $this->getDoctrine()->getRepository(Region::class)->findOneBy(['id'=>$req_region]);
        $districts = $this->getDoctrine()->getRepository(District::class)->findBy(['region'=>$req_region],['nom'=>"ASC"]);

        $homme = 0; $femme = 0; $garcon = 0; $fille = 0; $genres = []; $i=0;
        foreach ($districts as $district){
            $nombre = count($this->getDoctrine()->getRepository(Scout::class)->getNombreByDistrict($district->getId(), $annee));
            $statuts = $this->getDoctrine()->getRepository(Statut::class)->findAll();
            foreach ($statuts as $statut){
                if ($statut->getLibelle() === self::JEUNE){
                    $garcon = count($this->getDoctrine()->getRepository(Scout::class)->findByGenreDistrict($district->getId(),$statut->getId(), self::HOMME,$annee, self::M));
                    $fille = count($this->getDoctrine()->getRepository(Scout::class)->findByGenre($district->getId(),$statut->getId(), self::FEMME,$annee, self::F));
                }else{
                    $homme = count($this->getDoctrine()->getRepository(Scout::class)->findByGenre($district->getId(),$statut->getId(), self::HOMME,$annee, self::M));
                    $femme = count($this->getDoctrine()->getRepository(Scout::class)->findByGenre($district->getId(),$statut->getId(), self::FEMME,$annee, self::F));
                }
            }
            $genres[$i++] = [
                'district' => $district->getNom(),
                'homme' => $homme,
                'femme' => $femme,
                'garcon' => $garcon,
                'fille' => $fille,
                'total' => $nombre
            ];
        }

        return $this->render('backend/genre_region.html.twig',[
            'genres' => $genres,
            'regions' => $regions,
            'annee' => $annee
        ]);
    }
}