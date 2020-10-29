<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cotisation
 *
 * @ORM\Table(name="cotisation", indexes={@ORM\Index(name="IDX_AE64D2ED486EE6BB", columns={"scout_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\CotisationRepository")
 */
class Cotisation
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
     * @var string|null
     *
     * @ORM\Column(name="annee", type="string", length=255, nullable=true)
     */
    private $annee;

    /**
     * @var string|null
     *
     * @ORM\Column(name="fonction", type="string", length=255, nullable=true)
     */
    private $fonction;

    /**
     * @var string|null
     *
     * @ORM\Column(name="carte", type="string", length=255, nullable=true)
     */
    private $carte;

    /**
     * @var string|null
     *
     * @ORM\Column(name="montant", type="string", length=255, nullable=true)
     */
    private $montant;

    /**
     * @var int|null
     *
     * @ORM\Column(name="montant_san_frais", type="integer", nullable=true)
     */
    private $montantSanFrais;

    /**
     * @var int|null
     *
     * @ORM\Column(name="ristourne", type="integer", nullable=true)
     */
    private $ristourne;

    /**
     * @var \Scout
     *
     * @ORM\ManyToOne(targetEntity="Scout")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="scout_id", referencedColumnName="id")
     * })
     */
    private $scout;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnnee(): ?string
    {
        return $this->annee;
    }

    public function setAnnee(?string $annee): self
    {
        $this->annee = $annee;

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

    public function getCarte(): ?string
    {
        return $this->carte;
    }

    public function setCarte(?string $carte): self
    {
        $this->carte = $carte;

        return $this;
    }

    public function getMontant(): ?string
    {
        return $this->montant;
    }

    public function setMontant(?string $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getMontantSanFrais(): ?int
    {
        return $this->montantSanFrais;
    }

    public function setMontantSanFrais(?int $montantSanFrais): self
    {
        $this->montantSanFrais = $montantSanFrais;

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

    public function getScout(): ?Scout
    {
        return $this->scout;
    }

    public function setScout(?Scout $scout): self
    {
        $this->scout = $scout;

        return $this;
    }


}
