<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Gestionnaire
 *
 * @ORM\Table(name="gestionnaire", indexes={@ORM\Index(name="IDX_F4461B2098260155", columns={"region_id"}), @ORM\Index(name="IDX_F4461B20A76ED395", columns={"user_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\GestionnaireRepository")
 */
class Gestionnaire
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
     * @var string|null
     *
     * @ORM\Column(name="contact", type="string", length=255, nullable=true)
     */
    private $contact;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=20, nullable=false)
     */
    private $slug;

    /**
     * @var string|null
     *
     * @ORM\Column(name="publie_par", type="string", length=25, nullable=true)
     */
    private $publiePar;

    /**
     * @var string|null
     *
     * @ORM\Column(name="modifie_par", type="string", length=25, nullable=true)
     */
    private $modifiePar;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="publie_le", type="datetime", nullable=true)
     */
    private $publieLe;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="modifie_le", type="datetime", nullable=true)
     */
    private $modifieLe;

    /**
     * @var \Region
     *
     * @ORM\ManyToOne(targetEntity="Region")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="region_id", referencedColumnName="id")
     * })
     */
    private $region;

    /**
     * @var \FosUser
     *
     * @ORM\ManyToOne(targetEntity="FosUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(?string $contact): self
    {
        $this->contact = $contact;

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

    public function getPubliePar(): ?string
    {
        return $this->publiePar;
    }

    public function setPubliePar(?string $publiePar): self
    {
        $this->publiePar = $publiePar;

        return $this;
    }

    public function getModifiePar(): ?string
    {
        return $this->modifiePar;
    }

    public function setModifiePar(?string $modifiePar): self
    {
        $this->modifiePar = $modifiePar;

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

    public function getModifieLe(): ?\DateTimeInterface
    {
        return $this->modifieLe;
    }

    public function setModifieLe(?\DateTimeInterface $modifieLe): self
    {
        $this->modifieLe = $modifieLe;

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

    public function getUser(): ?FosUser
    {
        return $this->user;
    }

    public function setUser(?FosUser $user): self
    {
        $this->user = $user;

        return $this;
    }


}
