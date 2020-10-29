<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Paiements
 *
 * @ORM\Table(name="paiements", indexes={@ORM\Index(name="IDX_E1B02E12C1EA3D46", columns={"userinfo_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\PaiementsRepository")
 */
class Paiements
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
     * @ORM\Column(name="cpm_site_id", type="string", length=255, nullable=true)
     */
    private $cpmSiteId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="signature", type="string", length=255, nullable=true)
     */
    private $signature;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cpm_amount", type="string", length=255, nullable=true)
     */
    private $cpmAmount;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cpm_trans_id", type="string", length=255, nullable=true)
     */
    private $cpmTransId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cpm_custom", type="string", length=255, nullable=true)
     */
    private $cpmCustom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cpm_currency", type="string", length=255, nullable=true)
     */
    private $cpmCurrency;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cpm_payid", type="string", length=255, nullable=true)
     */
    private $cpmPayid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cpm_payment_date", type="string", length=255, nullable=true)
     */
    private $cpmPaymentDate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cpm_payment_time", type="string", length=255, nullable=true)
     */
    private $cpmPaymentTime;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cpm_error_message", type="string", length=255, nullable=true)
     */
    private $cpmErrorMessage;

    /**
     * @var string|null
     *
     * @ORM\Column(name="payment_method", type="string", length=255, nullable=true)
     */
    private $paymentMethod;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cpm_phone_prefixe", type="string", length=255, nullable=true)
     */
    private $cpmPhonePrefixe;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cel_phone_num", type="string", length=255, nullable=true)
     */
    private $celPhoneNum;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cpm_ipn_ack", type="string", length=255, nullable=true)
     */
    private $cpmIpnAck;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cpm_result", type="string", length=255, nullable=true)
     */
    private $cpmResult;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cpm_trans_status", type="string", length=255, nullable=true)
     */
    private $cpmTransStatus;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cpm_designation", type="string", length=255, nullable=true)
     */
    private $cpmDesignation;

    /**
     * @var string|null
     *
     * @ORM\Column(name="buyer_name", type="string", length=255, nullable=true)
     */
    private $buyerName;

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
     * @var \UserInfos
     *
     * @ORM\ManyToOne(targetEntity="UserInfos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="userinfo_id", referencedColumnName="id")
     * })
     */
    private $userinfo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCpmSiteId(): ?string
    {
        return $this->cpmSiteId;
    }

    public function setCpmSiteId(?string $cpmSiteId): self
    {
        $this->cpmSiteId = $cpmSiteId;

        return $this;
    }

    public function getSignature(): ?string
    {
        return $this->signature;
    }

    public function setSignature(?string $signature): self
    {
        $this->signature = $signature;

        return $this;
    }

    public function getCpmAmount(): ?string
    {
        return $this->cpmAmount;
    }

    public function setCpmAmount(?string $cpmAmount): self
    {
        $this->cpmAmount = $cpmAmount;

        return $this;
    }

    public function getCpmTransId(): ?string
    {
        return $this->cpmTransId;
    }

    public function setCpmTransId(?string $cpmTransId): self
    {
        $this->cpmTransId = $cpmTransId;

        return $this;
    }

    public function getCpmCustom(): ?string
    {
        return $this->cpmCustom;
    }

    public function setCpmCustom(?string $cpmCustom): self
    {
        $this->cpmCustom = $cpmCustom;

        return $this;
    }

    public function getCpmCurrency(): ?string
    {
        return $this->cpmCurrency;
    }

    public function setCpmCurrency(?string $cpmCurrency): self
    {
        $this->cpmCurrency = $cpmCurrency;

        return $this;
    }

    public function getCpmPayid(): ?string
    {
        return $this->cpmPayid;
    }

    public function setCpmPayid(?string $cpmPayid): self
    {
        $this->cpmPayid = $cpmPayid;

        return $this;
    }

    public function getCpmPaymentDate(): ?string
    {
        return $this->cpmPaymentDate;
    }

    public function setCpmPaymentDate(?string $cpmPaymentDate): self
    {
        $this->cpmPaymentDate = $cpmPaymentDate;

        return $this;
    }

    public function getCpmPaymentTime(): ?string
    {
        return $this->cpmPaymentTime;
    }

    public function setCpmPaymentTime(?string $cpmPaymentTime): self
    {
        $this->cpmPaymentTime = $cpmPaymentTime;

        return $this;
    }

    public function getCpmErrorMessage(): ?string
    {
        return $this->cpmErrorMessage;
    }

    public function setCpmErrorMessage(?string $cpmErrorMessage): self
    {
        $this->cpmErrorMessage = $cpmErrorMessage;

        return $this;
    }

    public function getPaymentMethod(): ?string
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(?string $paymentMethod): self
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    public function getCpmPhonePrefixe(): ?string
    {
        return $this->cpmPhonePrefixe;
    }

    public function setCpmPhonePrefixe(?string $cpmPhonePrefixe): self
    {
        $this->cpmPhonePrefixe = $cpmPhonePrefixe;

        return $this;
    }

    public function getCelPhoneNum(): ?string
    {
        return $this->celPhoneNum;
    }

    public function setCelPhoneNum(?string $celPhoneNum): self
    {
        $this->celPhoneNum = $celPhoneNum;

        return $this;
    }

    public function getCpmIpnAck(): ?string
    {
        return $this->cpmIpnAck;
    }

    public function setCpmIpnAck(?string $cpmIpnAck): self
    {
        $this->cpmIpnAck = $cpmIpnAck;

        return $this;
    }

    public function getCpmResult(): ?string
    {
        return $this->cpmResult;
    }

    public function setCpmResult(?string $cpmResult): self
    {
        $this->cpmResult = $cpmResult;

        return $this;
    }

    public function getCpmTransStatus(): ?string
    {
        return $this->cpmTransStatus;
    }

    public function setCpmTransStatus(?string $cpmTransStatus): self
    {
        $this->cpmTransStatus = $cpmTransStatus;

        return $this;
    }

    public function getCpmDesignation(): ?string
    {
        return $this->cpmDesignation;
    }

    public function setCpmDesignation(?string $cpmDesignation): self
    {
        $this->cpmDesignation = $cpmDesignation;

        return $this;
    }

    public function getBuyerName(): ?string
    {
        return $this->buyerName;
    }

    public function setBuyerName(?string $buyerName): self
    {
        $this->buyerName = $buyerName;

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

    public function getUserinfo(): ?UserInfos
    {
        return $this->userinfo;
    }

    public function setUserinfo(?UserInfos $userinfo): self
    {
        $this->userinfo = $userinfo;

        return $this;
    }


}
