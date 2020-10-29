<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Recherche
 *
 * @ORM\Entity
 */
class Recherche
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
     * @ORM\Column (name="matricule", type="string")
     */
    private $matricule;

    /**
     * @var string|null
     *
     * @ORM\Column (name="nom", type="string")
     */
    private $nom;

    /**
     * @var string|null
     *
     * @ORM\Column (name="prenoms", type="string")
     */
    private $prenoms;

    /**
     * @var string|null
     *
     * @ORM\Column (name="date_naissance", type="string")
     */
    private $dateNaissance;

    /**
     * @var string|null
     *
     * @ORM\Column (name="lieu_naissance", type="string")
     */
    private $lieuNaissance;

    /**
     * @return string|null
     */
    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    /**
     * @param string|null $matricule
     */
    public function setMatricule(?string $matricule): void
    {
        $this->matricule = $matricule;
    }

    /**
     * @return string|null
     */
    public function getNom(): ?string
    {
        return $this->nom;
    }

    /**
     * @param string|null $nom
     */
    public function setNom(?string $nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return string|null
     */
    public function getPrenoms(): ?string
    {
        return $this->prenoms;
    }

    /**
     * @param string|null $prenoms
     */
    public function setPrenoms(?string $prenoms): void
    {
        $this->prenoms = $prenoms;
    }

    /**
     * @return string|null
     */
    public function getDateNaissance(): ?string
    {
        return $this->dateNaissance;
    }

    /**
     * @param string|null $dateNaissance
     */
    public function setDateNaissance(?string $dateNaissance): void
    {
        $this->dateNaissance = $dateNaissance;
    }

    /**
     * @return string|null
     */
    public function getLieuNaissance(): ?string
    {
        return $this->lieuNaissance;
    }

    /**
     * @param string|null $lieuNaissance
     */
    public function setLieuNaissance(?string $lieuNaissance): void
    {
        $this->lieuNaissance = $lieuNaissance;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }
}