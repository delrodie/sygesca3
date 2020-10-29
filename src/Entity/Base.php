<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Base
 *
 * @ORM\Table(name="base")
 * @ORM\Entity
 */
class Base
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
     * @ORM\Column(name="libelle", type="string", length=255, nullable=true)
     */
    private $libelle;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=0, nullable=true)
     */
    private $description;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="statut", type="boolean", nullable=true)
     */
    private $statut;

    /**
     * @var string
     *
     * @ORM\Column(name="image_name", type="string", length=255, nullable=false)
     */
    private $imageName;

    /**
     * @var int|null
     *
     * @ORM\Column(name="image_size", type="integer", nullable=true)
     */
    private $imageSize;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=75, nullable=false)
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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(?bool $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(string $imageName): self
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    public function setImageSize(?int $imageSize): self
    {
        $this->imageSize = $imageSize;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

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


}
