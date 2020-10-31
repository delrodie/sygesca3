<?php

namespace App\Entity;

use App\Repository\UserInfo2020Repository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserInfo2020Repository::class)
 */
class UserInfo2020
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prenoms;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lieuNaissance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sexe;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contact;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $urgence;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contactParent;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $branche;

    /**
     * @ORM\ManyToOne(targetEntity=Region::class)
     */
    private $region;

    /**
     * @ORM\ManyToOne(targetEntity=District::class)
     */
    private $district;

    /**
     * @ORM\ManyToOne(targetEntity=Groupe::class)
     */
    private $groupe;

    /**
     * @ORM\ManyToOne(targetEntity=Fonctions::class)
     */
    private $fonction;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $idTransaction;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $statusPaiement;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numeroPaiement;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $statut;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $matricule;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenoms(): ?string
    {
        return $this->prenoms;
    }

    public function setPrenoms(?string $prenoms): self
    {
        $this->prenoms = $prenoms;

        return $this;
    }

    public function getDateNaissance(): ?string
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(?string $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getLieuNaissance(): ?string
    {
        return $this->lieuNaissance;
    }

    public function setLieuNaissance(?string $lieuNaissance): self
    {
        $this->lieuNaissance = $lieuNaissance;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(?string $sexe): self
    {
        $this->sexe = $sexe;

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

    public function getUrgence(): ?string
    {
        return $this->urgence;
    }

    public function setUrgence(?string $urgence): self
    {
        $this->urgence = $urgence;

        return $this;
    }

    public function getContactParent(): ?string
    {
        return $this->contactParent;
    }

    public function setContactParent(?string $contactParent): self
    {
        $this->contactParent = $contactParent;

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

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getDistrict(): ?District
    {
        return $this->district;
    }

    public function setDistrict(?District $district): self
    {
        $this->district = $district;

        return $this;
    }

    public function getGroupe(): ?Groupe
    {
        return $this->groupe;
    }

    public function setGroupe(?Groupe $groupe): self
    {
        $this->groupe = $groupe;

        return $this;
    }

    public function getFonction(): ?Fonctions
    {
        return $this->fonction;
    }

    public function setFonction(?Fonctions $fonction): self
    {
        $this->fonction = $fonction;

        return $this;
    }

    public function getIdTransaction(): ?string
    {
        return $this->idTransaction;
    }

    public function setIdTransaction(?string $idTransaction): self
    {
        $this->idTransaction = $idTransaction;

        return $this;
    }

    public function getStatusPaiement(): ?string
    {
        return $this->statusPaiement;
    }

    public function setStatusPaiement(?string $statusPaiement): self
    {
        $this->statusPaiement = $statusPaiement;

        return $this;
    }

    public function getNumeroPaiement(): ?string
    {
        return $this->numeroPaiement;
    }

    public function setNumeroPaiement(?string $numeroPaiement): self
    {
        $this->numeroPaiement = $numeroPaiement;

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

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(?string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }
}
