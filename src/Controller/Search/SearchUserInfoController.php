<?php


namespace App\Controller\Search;


use App\Entity\Fonctions;
use App\Entity\UserInfo2020;
use App\Form\UserInfo2020Type;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SearchUserInfoController
 * @Route("/backend/userinfo")
 */
class SearchUserInfoController extends AbstractController
{

    /**
     * @Route("/{id_transaction}", name="backend_userinfo_search", methods={"GET","POST"})
     */
    public function search(Request $request): Response
    {
        $idTransaction = $request->get('id_transaction');

        /**
         * Recherche de l'User concerné par l'identifiant de la transaction
         * S'il existe alors afficher le formulaire de modification
         * Sinon afficher le tableau des transactions échouées
         */

        $userInfo = $this->getDoctrine()->getRepository(UserInfo2020::class)->findOneBy(['idTransaction'=>$idTransaction]);
        if (!$userInfo){
            $this->addFlash('danger', "L'identifiant de la transaction n'existe pas");
            return $this->redirectToRoute('backend_user_paiement_unknow');
        }
        $form = $this->createForm(UserInfo2020Type::class, $userInfo);
        $form->handleRequest($request);

        // Initialisation de la variable message
        $message = [];

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager(); //dd($userInfo);
            $entityManager->flush();

            $lien = "http://adhesion.scoutascci.org/cinetpay/notify?cpm_trans_id=".$userInfo->getIdTransaction();

            return $this->redirect($lien);
        }

        return $this->render('search/unserinfo.html.twig',[
            'userInfo' => $userInfo,
            'form' => $form->createView(),
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
}