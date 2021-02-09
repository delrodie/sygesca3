<?php

namespace App\Controller;

use App\Entity\Scout;
use App\Entity\UserInfo2020;
use App\Repository\DistrictRepository;
use App\Repository\FonctionRepository;
use App\Repository\GroupeRepository;
use App\Repository\RegionRepository;
use App\Repository\ScoutRepository;
use App\Repository\UserInfo2020Repository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class AdhesionController
 * @Route("/adhesion")
 */
class AdhesionController extends AbstractController
{
    private $scoutRepository;
    private $fonctionRepository;
    private $regionRepository;
    private $districtRepository;
    private $groupeRepository;
    private $userInfo2020Repository;

    public function __construct(ScoutRepository $scoutRepository, FonctionRepository $fonctionRepository, RegionRepository $regionRepository, DistrictRepository $districtRepository, GroupeRepository $groupeRepository, UserInfo2020Repository $userInfo2020Repository)
    {
        $this->scoutRepository = $scoutRepository;
        $this->fonctionRepository = $fonctionRepository;
        $this->regionRepository = $regionRepository;
        $this->districtRepository = $districtRepository;
        $this->groupeRepository = $groupeRepository;
        $this->userInfo2020Repository = $userInfo2020Repository;
    }

    /**
     * @Route("/", name="adhesion_inscription", methods={"GET","POST"})
     */
    public function index(Request $request): Response
    {

        $em = $this->getDoctrine()->getManager();

        //Initialisation
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);


        $nom= strtoupper($this->validForm($request->get('adhesion_nom')));
        $prenoms = strtoupper($this->validForm($request->get('adhesion_prenoms')));
        $contact = $this->validForm($request->get('adhesion_contact'));
        $dateNaissance = $this->validForm($request->get('adhesion_datenaissance'));
        $lieuNaissance = strtoupper($this->validForm($request->get('adhesion_lieunaissance')));
        $sexe = $this->validForm($request->get('adhesion_sexe'));
        $branche = $this->validForm($request->get('adhesion_branche'));
        $region = $this->validForm($request->get('adhesion_region'));
        $district = $this->validForm($request->get('adhesion_district'));
        $groupe = $this->validForm($request->get('adhesion_groupe'));
        $fonction = $this->validForm($request->get('adhesion_fonction'));
        $urgence = $this->validForm($request->get('adhesion_urgence'));
        $contactParent = $this->validForm($request->get('adhesion_contact_parent'));
        $matricule = $this->validForm($request->get('adhesion_matricule'));

        // Verification de l'existence
        $userInfo2020 = $this->userInfo2020Repository->findOneBy([
            'nom' => $nom,
            'prenoms' => $prenoms,
            'dateNaissance' => $dateNaissance,
            'lieuNaissance' => $lieuNaissance,
            'contact' => $contact,
            'contactParent' => $contactParent
        ]);

        $region = $this->regionRepository->findOneBy(['id'=>$region]);
        $district = $this->districtRepository->findOneBy(['id'=>$district]);
        $groupe = $this->groupeRepository->findOneBy(['id'=>$groupe]);
        $fonction = $this->fonctionRepository->findOneBy(['id'=>$fonction]);

        $id_transaction = time().'-'.uniqid();
        $status_paiement = 'UNKNOW';

        if ($userInfo2020){
            // Verification si la transaction precedente a abouti sinon faire une mise a jour
            if ($userInfo2020->getStatut() != '00' && $userInfo2020->getStatusPaiement()!= 'VALID'){
                $userInfo2020->setBranche($branche);
                $userInfo2020->setUrgence($urgence);
                $userInfo2020->setContactParent($contactParent);
                $userInfo2020->setRegion($region);
                $userInfo2020->setDistrict($district);
                $userInfo2020->setGroupe($groupe);
                $userInfo2020->setFonction($fonction);
                $userInfo2020->setContact($contact);
                $userInfo2020->setIdTransaction($userInfo2020->getIdTransaction());

                $em->flush();

                $montant = $fonction->getMontant();

                $am = (int)$montant/ (1 - 0.035) ;
                $am = $this->arrondiSuperieur($am, 5);

                $message = [
                    'id'=> $userInfo2020->getIdTransaction(),
                    'status' => true,
                    'amount' => $am,
                ];
            }else{
                $message = [
                    'msg' => "Vous êtes déjà inscrit(e)",
                    'status' => false
                ];
            }

            return $this->json($message);

        }else{


            $userInfo2020 = new UserInfo2020();
            $userInfo2020->setNom($nom);
            $userInfo2020->setPrenoms($prenoms);
            $userInfo2020->setDateNaissance($dateNaissance);
            $userInfo2020->setLieuNaissance($lieuNaissance);
            $userInfo2020->setSexe($sexe);
            $userInfo2020->setBranche($branche);
            $userInfo2020->setUrgence($urgence);
            $userInfo2020->setContactParent($contactParent);
            $userInfo2020->setRegion($region);
            $userInfo2020->setDistrict($district);
            $userInfo2020->setGroupe($groupe);
            $userInfo2020->setFonction($fonction);
            $userInfo2020->setContact($contact);
            $userInfo2020->setIdTransaction($id_transaction);
            $userInfo2020->setStatusPaiement($status_paiement);
            $userInfo2020->setMatricule($matricule);

            $em->persist($userInfo2020);
            $em->flush();

            $montant = $fonction->getMontant();

            $am = (int)$montant/ (1 - 0.035) ;
            $am = $this->arrondiSuperieur($am, 5);

            $message = [
                'id'=> $id_transaction,
                'status' => true,
                'amount' => $am,
            ];

            return $this->json($message);

        }

        return $this->render('adhesion/index.html.twig', [
            'controller_name' => 'AdhesionController',
        ]);
    }

    /**
     * @Route("/{slug}", name="adhesion_ancien", methods={"GET","POST"})
     */
    public function ancien(Request $request, Scout $scout)
    { //dd($scout);
        return $this->render('adhesion/ancien.html.twig',[
            'scout' => $scout,
            'fonctions' => $this->fonctionRepository->findAll(),
            'regions' => $this->regionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/ajax/requete", name="adhesion_requete_ajax", methods={"GET","POST"})
     */
    public function ajax(Request $request)
    {
        //Initialisation
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $field = $request->get('field');
        $value = $request->get('value');
        if ($field === 'region'){
            $districts = $this->districtRepository->findBy(['region'=>$value],['nom'=>"ASC"]);

            $data = $this->json($districts);

        }elseif ($field === 'district'){
            $groupes = $this->groupeRepository->findBy(['district'=>$value],['paroisse'=>"ASC"]);
            $data = $this->json($groupes);
        }elseif($field === 'fonction'){
            $fonction = $this->fonctionRepository->findOneBy(['id'=>$value])->getMontant();
            $result = (int)$fonction / (1 - 0.035);
            $result = $this->arrondiSuperieur($result, 5);
            $data = $this->json($result);
        }

        return $data;
    }

    /**
     * @Route("/inscription/nouvelle/", name="adhesion_nouvelle_inscription", methods={"GET","POST"})
     */
    public function nouvelle()
    {
        return $this->render('adhesion/nouveau.html.twig',[
            'fonctions'=> $this->fonctionRepository->findAll(),
            'regions' => $this->regionRepository->findAll()
        ]);
    }

    /**
     * Fonction pour arrondir au supérieur
     *
     * @param $nombre
     * @param $arrondi
     * @return float|int
     */
    public function arrondiSuperieur($nombre, $arrondi)
    {
        return ceil($nombre / $arrondi) * $arrondi;
    }

    /**
     * fonction verification des valeurs
     *
     * @param $donnee
     * @return string
     */
    public function validForm($donnee)
    {
        $result = htmlspecialchars(stripslashes(trim($donnee)));

        return $result;
    }
}
