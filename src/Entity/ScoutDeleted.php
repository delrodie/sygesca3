<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ScoutDeleted
 *
 * @ORM\Table(name="scout_deleted")
 * @ORM\Entity
 */
class ScoutDeleted
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="matricule", type="string", length=255, nullable=false)
     */
    private $matricule;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenoms", type="string", length=255, nullable=false)
     */
    private $prenoms;

    /**
     * @var string
     *
     * @ORM\Column(name="datenaiss", type="string", length=255, nullable=false)
     */
    private $datenaiss;

    /**
     * @var string
     *
     * @ORM\Column(name="lieunaiss", type="string", length=255, nullable=false)
     */
    private $lieunaiss;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=255, nullable=false)
     */
    private $sexe;

    /**
     * @var string|null
     *
     * @ORM\Column(name="branche", type="string", length=255, nullable=true)
     */
    private $branche;

    /**
     * @var string|null
     *
     * @ORM\Column(name="fonction", type="string", length=255, nullable=true)
     */
    private $fonction;

    /**
     * @var string|null
     *
     * @ORM\Column(name="contact", type="string", length=255, nullable=true)
     */
    private $contact;

    /**
     * @var string|null
     *
     * @ORM\Column(name="contactParent", type="string", length=255, nullable=true)
     */
    private $contactparent;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="carte", type="string", length=255, nullable=true)
     */
    private $carte;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cotisation", type="string", length=255, nullable=true)
     */
    private $cotisation;

    /**
     * @var string|null
     *
     * @ORM\Column(name="urgence", type="string", length=255, nullable=true)
     */
    private $urgence;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=false)
     */
    private $slug;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="publie_le", type="datetime", nullable=true)
     */
    private $publieLe;

    /**
     * @var string|null
     *
     * @ORM\Column(name="supprime_le", type="string", length=255, nullable=true)
     */
    private $supprimeLe;

    /**
     * @var string|null
     *
     * @ORM\Column(name="statut", type="string", length=255, nullable=true)
     */
    private $statut;

    /**
     * @var string|null
     *
     * @ORM\Column(name="groupe", type="string", length=255, nullable=true)
     */
    private $groupe;

    /**
     * @var string|null
     *
     * @ORM\Column(name="district", type="string", length=255, nullable=true)
     */
    private $district;

    /**
     * @var string|null
     *
     * @ORM\Column(name="region", type="string", length=255, nullable=true)
     */
    private $region;

    /**
     * @var int|null
     *
     * @ORM\Column(name="montant", type="integer", nullable=true)
     */
    private $montant;

    /**
     * @var int|null
     *
     * @ORM\Column(name="montant_sans_frais", type="integer", nullable=true)
     */
    private $montantSansFrais;

    /**
     * @var int|null
     *
     * @ORM\Column(name="ristourne", type="integer", nullable=true)
     */
    private $ristourne;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenoms(): ?string
    {
        return $this->prenoms;
    }

    public function setPrenoms(string $prenoms): self
    {
        $this->prenoms = $prenoms;

        return $this;
    }

    public function getDatenaiss(): ?string
    {
        return $this->datenaiss;
    }

    public function setDatenaiss(string $datenaiss): self
    {
        $this->datenaiss = $datenaiss;

        return $this;
    }

    public function getLieunaiss(): ?string
    {
        return $this->lieunaiss;
    }

    public function setLieunaiss(string $lieunaiss): self
    {
        $this->lieunaiss = $lieunaiss;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getBranche(): ?string
    {
        return $this->branche;
    }

    public function setBranche(?string $branche): self
    {
        $this->branche = $branche;

        return $this;
    }

    public function getFonction(): ?string
    {
        return $this->fonction;
    }

    public function setFonction(?string $fonction): self
    {
        $this->fonction = $fonction;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(?string $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getContactparent(): ?string
    {
        return $this->contactparent;
    }

    public function setContactparent(?string $contactparent): self
    {
        $this->contactparent = $contactparent;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getCarte(): ?string
    {
        return $this->carte;
    }

    public function setCarte(?string $carte): self
    {
        $this->carte = $carte;

        return $this;
    }

    public function getCotisation(): ?string
    {
        return $this->cotisation;
    }

    public function setCotisation(?string $cotisation): self
    {
        $this->cotisation = $cotisation;

        return $this;
    }

    public function getUrgence(): ?string
    {
        return $this->urgence;
    }

    public function setUrgence(?string $urgence): self
    {
        $this->urgence = $urgence;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getPublieLe(): ?\DateTimeInterface
    {
        return $this->publieLe;
    }

    public function setPublieLe(?\DateTimeInterface $publieLe): self
    {
        $this->publieLe = $publieLe;

        return $this;
    }

    public function getSupprimeLe(): ?string
    {
        return $this->supprimeLe;
    }

    public function setSupprimeLe(?string $supprimeLe): self
    {
        $this->supprimeLe = $supprimeLe;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getGroupe(): ?string
    {
        return $this->groupe;
    }

    public function setGroupe(?string $groupe): self
    {
        $this->groupe = $groupe;

        return $this;
    }

    public function getDistrict(): ?string
    {
        return $this->district;
    }

    public function setDistrict(?string $district): self
    {
        $this->district = $district;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(?int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getMontantSansFrais(): ?int
    {
        return $this->montantSansFrais;
    }

    public function setMontantSansFrais(?int $montantSansFrais): self
    {
        $this->montantSansFrais = $montantSansFrais;

        return $this;
    }

    public function getRistourne(): ?int
    {
        return $this->ristourne;
    }

    public function setRistourne(?int $ristourne): self
    {
        $this->ristourne = $ristourne;

        return $this;
    }


}
