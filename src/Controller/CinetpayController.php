<?php

namespace App\Controller;

use App\Entity\Scout;
use App\Repository\DistrictRepository;
use App\Repository\FonctionRepository;
use App\Repository\GroupeRepository;
use App\Repository\RegionRepository;
use App\Repository\ScoutRepository;
use App\Repository\StatutRepository;
use App\Repository\UserInfo2020Repository;
use App\Utilities\GestionCotisation;
use App\Utilities\GestionScout;
use CinetPay\CinetPay;
use Cocur\Slugify\Slugify;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class CinetpayController
 * @Route("/cinetpay")
 */
class CinetpayController extends AbstractController
{
    private $userInfo2020Repository;
    private $scoutRepository;
    private $fonctionRepository;
    private $regionRepository;
    private $districtRepository;
    private $groupeRepository;
    private $statutRepository;
    private $gestionScout;
    private $gestionCotisation;

    public function __construct(
        ScoutRepository $scoutRepository,
        FonctionRepository $fonctionRepository,
        UserInfo2020Repository $userInfo2020Repository,
        RegionRepository $regionRepository,
        DistrictRepository $districtRepository,
        GroupeRepository $groupeRepository,
        StatutRepository $statutRepository,
        GestionScout $gestionScout,
        GestionCotisation $gestionCotisation
    )
    {
        $this->scoutRepository= $scoutRepository;
        $this->fonctionRepository = $fonctionRepository;
        $this->userInfo2020Repository = $userInfo2020Repository;
        $this->regionRepository = $regionRepository;
        $this->districtRepository = $districtRepository;
        $this->groupeRepository = $groupeRepository;
        $this->statutRepository = $statutRepository;
        $this->gestionScout = $gestionScout;
        $this->gestionCotisation = $gestionCotisation;
    }

    /**
     * @Route("/notify", name="cinetpay_notification", methods={"GET","POST"})
     */
    public function index(Request $request): Response
    {
        //Initialisation
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $em = $this->getDoctrine()->getManager();

        $cpmTransId = $request->get('cpm_trans_id');
        if (isset($cpmTransId)) {


            try {
                // Initialisation de CinetPay et Identification du paiement
                $id_transaction = $cpmTransId;
                $apiKey = '18714242495c8ba3f4cf6068.77597603';
                $site_id = 422630;
                $plateform = "PROD"; // Valorisé à PROD si vous êtes en production
                $CinetPay = new CinetPay($site_id, $apiKey, $plateform);
                // Reprise exacte des bonnes données chez CinetPay
                $CinetPay->setTransId($id_transaction)->getPayStatus();
                $cpm_site_id = $CinetPay->_cpm_site_id;
                $signature = $CinetPay->_signature;
                $cpm_amount = $CinetPay->_cpm_amount;
                $cpm_trans_id = $CinetPay->_cpm_trans_id;
                $cpm_custom = $CinetPay->_cpm_custom;
                $cpm_currency = $CinetPay->_cpm_currency;
                $cpm_payid = $CinetPay->_cpm_payid;
                $cpm_payment_date = $CinetPay->_cpm_payment_date;
                $cpm_payment_time = $CinetPay->_cpm_payment_time;
                $cpm_error_message = $CinetPay->_cpm_error_message;
                $payment_method = $CinetPay->_payment_method;
                $cpm_phone_prefixe = $CinetPay->_cpm_phone_prefixe;
                $cel_phone_num = $CinetPay->_cel_phone_num;
                $cpm_ipn_ack = $CinetPay->_cpm_ipn_ack;
                $created_at = $CinetPay->_created_at;
                $updated_at = $CinetPay->_updated_at;
                $cpm_result = $CinetPay->_cpm_result;
                $cpm_trans_status = $CinetPay->_cpm_trans_status;
                $cpm_designation = $CinetPay->_cpm_designation;
                $buyer_name = $CinetPay->_buyer_name;

                // Vérification si l'operation de cinetpay est effective
                if ($cpm_result == '00'){
                    // Verification de la transaction de la base de données
                    $userInfo = $this->userInfo2020Repository->findOneBy(['idTransaction'=>$id_transaction]);
                    if ($userInfo->getStatut() == '00'){
                        $message = [
                            'id'=> $id_transaction
                        ];

                        return $this->json($message);
                    }
                    else{
                        $fonction = $this->fonctionRepository->findOneBy(['id'=>$userInfo->getFonction()]);
                        $groupe = $this->groupeRepository->findOneBy(['id'=>$userInfo->getGroupe()]);
                        $region = $this->regionRepository->findOneBy(['id'=>$userInfo->getRegion()]);

                        // Rechercher le type de scout (Jeune ou Adulte)
                        if ($fonction->getId() < 5){
                            $branche = $fonction->getLibelle();
                            $scout_statut = $this->statutRepository->findOneBy(['id'=>1]);
                        }else{
                            $branche = $userInfo->getBranche();
                            $scout_statut = $this->statutRepository->findOneBy(['id'=>2]);
                        }
                        // Verification du statut du scout (ancien ou nouveau)
                        $scout = $this->scoutRepository->findOneBy([
                            'nom' => $userInfo->getNom(),
                            'prenoms' => $userInfo->getPrenoms(),
                            'datenaiss' => $userInfo->getDateNaissance(),
                            'lieunaiss' => $userInfo->getLieuNaissance(),
                            'matricule' => $userInfo->getMatricule()
                        ]);

                        if ($scout){
                            $scout->setContact($userInfo->getContact());
                            $scout->setUrgence($userInfo->getUrgence());
                            $scout->setContactparent($userInfo->getContactParent());
                            $scout->setGroupe($groupe);
                            $scout->setFonction($fonction->getLibelle());
                            $scout->setGroupe($groupe);
                            $scout->setStatut($scout_statut);
                            $scout->setBranche($branche);

                            //
                            $scout->setCotisation($this->gestionScout->cotisation());

                        }else{
                            $scout = new Scout();
                            $slugify = new Slugify();

                            $matricule = $this->gestionScout->matricule($region->getId());

                            $slugger = $userInfo->getNom().'-'.$userInfo->getPrenoms().'-'.$matricule;
                            $slug = $slugify->slugify($slugger);

                            $scout->setNom($userInfo->getNom());
                            $scout->setPrenoms($userInfo->getPrenoms());
                            $scout->setDatenaiss($userInfo->getDateNaissance());
                            $scout->setLieunaiss($userInfo->getLieuNaissance());
                            $scout->setSexe($userInfo->getSexe());
                            $scout->setContact($userInfo->getContact());
                            $scout->setUrgence($userInfo->getUrgence());
                            $scout->setContactparent($userInfo->getContactParent());
                            $scout->setGroupe($groupe);
                            $scout->setFonction($fonction->getLibelle());
                            $scout->setStatut($scout_statut);
                            $scout->setBranche($branche);
                            $scout->setCotisation($this->gestionScout->cotisation());
                            $scout->setMatricule($matricule);
                            $scout->setSlug($slug);
                        }

                        $em->persist($scout);
                        $em->flush();

                        //Sauvegarde de la carte du scout
                        $this->gestionScout->carte($scout->getId(), $region->getCode());
                        $this->gestionCotisation->save($scout->getId(), $fonction->getId(), $cpm_amount);

                        $message=[
                            'id'=> $id_transaction,
                            'matricule' => $scout->getMatricule(),
                        ];

                        return $this->json($message);
                    }

                }else{
                    die('error');
                }

            } catch (Exception $e) {
                echo "Erreur :" . $e->getMessage();
                // Une erreur s'est produite
            }
        } else {
            // Tentative d'accès direct au lien IPN
        }

        //die('ici');
        return $this->redirectToRoute('app_accueil');
    }
}
