<?php


namespace App\Utilities;


use App\Entity\Cotisation;
use App\Repository\FonctionRepository;
use App\Repository\ScoutRepository;
use Doctrine\ORM\EntityManagerInterface;

class GestionCotisation
{
    private $em;
    private $gestionScout;
    private $scoutrepository;
    private $fonctionRepository;

    public function __construct(EntityManagerInterface $entityManager, GestionScout $gestionScout, ScoutRepository $scoutRepository, FonctionRepository $fonctionRepository)
    {
        $this->em = $entityManager;
        $this->gestionScout = $gestionScout;
        $this->scoutrepository= $scoutRepository;
        $this->fonctionRepository = $fonctionRepository;
    }

    /**
     * Enregistrement de la cotisation
     *
     * @param $scoutID
     * @param $fonctionID
     * @param null $montant
     * @return bool
     */
    public function save($scoutID, $fonctionID, $montant = null)
    {
        $cotisation = new Cotisation();
        $annee = $this->gestionScout->cotisation();
        $scout = $this->scoutrepository->findOneBy(['id'=>$scoutID]);
        $fonction = $this->fonctionRepository->findOneBy(['id'=>$fonctionID]);

        // si le scout est un jeune alors affecté la branche à la fonction
        $statut = $scout->getStatut()->getLibelle();
        if ($statut === 'jeune'){
            $cotisation->setFonction($scout->getBranche());
        }else{
            $cotisation->setFonction($scout->getFonction());
        }
        $cotisation->setAnnee($annee);
        $cotisation->setScout($scout);
        $cotisation->setCarte($scout->getCarte());
        $cotisation->setMontant($montant);
        $cotisation->setMontantSanFrais($fonction->getMontant());
        $cotisation->setRistourne($fonction->getRistourne());

        $this->em->persist($cotisation);
        $this->em->flush();

        return true;
    }
}