<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserInfos
 *
 * @ORM\Table(name="user_infos", indexes={@ORM\Index(name="IDX_C08793557889920", columns={"fonction_id"}), @ORM\Index(name="IDX_C0879357A45358C", columns={"groupe_id"}), @ORM\Index(name="IDX_C08793598260155", columns={"region_id"}), @ORM\Index(name="IDX_C087935B08FA272", columns={"district_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\UserInfosRepository")
 */
class UserInfos
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
     * @ORM\Column(name="first_name", type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="last_name", type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="birthday", type="string", length=255, nullable=true)
     */
    private $birthday;

    /**
     * @var string|null
     *
     * @ORM\Column(name="birth_location", type="string", length=255, nullable=true)
     */
    private $birthLocation;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sexe_adh", type="string", length=255, nullable=true)
     */
    private $sexeAdh;

    /**
     * @var string|null
     *
     * @ORM\Column(name="contact_name", type="string", length=255, nullable=true)
     */
    private $contactName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @var string|null
     *
     * @ORM\Column(name="num_perso", type="string", length=255, nullable=true)
     */
    private $numPerso;

    /**
     * @var string|null
     *
     * @ORM\Column(name="id_transaction", type="string", length=255, nullable=true)
     */
    private $idTransaction;

    /**
     * @var string|null
     *
     * @ORM\Column(name="status_paiement", type="string", length=255, nullable=true)
     */
    private $statusPaiement;

    /**
     * @var string|null
     *
     * @ORM\Column(name="created_at", type="string", length=255, nullable=true)
     */
    private $createdAt;

    /**
     * @var string|null
     *
     * @ORM\Column(name="updated_at", type="string", length=255, nullable=true)
     */
    private $updatedAt;

    /**
     * @var string|null
     *
     * @ORM\Column(name="branche", type="string", length=255, nullable=true)
     */
    private $branche;

    /**
     * @var \Fonctions
     *
     * @ORM\ManyToOne(targetEntity="Fonctions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fonction_id", referencedColumnName="id")
     * })
     */
    private $fonction;

    /**
     * @var \Groupe
     *
     * @ORM\ManyToOne(targetEntity="Groupe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="groupe_id", referencedColumnName="id")
     * })
     */
    private $groupe;

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
     * @var \District
     *
     * @ORM\ManyToOne(targetEntity="District")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="district_id", referencedColumnName="id")
     * })
     */
    private $district;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBirthday(): ?string
    {
        return $this->birthday;
    }

    public function setBirthday(?string $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getBirthLocation(): ?string
    {
        return $this->birthLocation;
    }

    public function setBirthLocation(?string $birthLocation): self
    {
        $this->birthLocation = $birthLocation;

        return $this;
    }

    public function getSexeAdh(): ?string
    {
        return $this->sexeAdh;
    }

    public function setSexeAdh(?string $sexeAdh): self
    {
        $this->sexeAdh = $sexeAdh;

        return $this;
    }

    public function getContactName(): ?string
    {
        return $this->contactName;
    }

    public function setContactName(?string $contactName): self
    {
        $this->contactName = $contactName;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getNumPerso(): ?string
    {
        return $this->numPerso;
    }

    public function setNumPerso(?string $numPerso): self
    {
        $this->numPerso = $numPerso;

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

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?string $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?string $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

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

    public function getFonction(): ?Fonctions
    {
        return $this->fonction;
    }

    public function setFonction(?Fonctions $fonction): self
    {
        $this->fonction = $fonction;

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


}
