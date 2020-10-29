<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExtLogEntries
 *
 * @ORM\Table(name="ext_log_entries", indexes={@ORM\Index(name="log_class_lookup_idx", columns={"object_class"}), @ORM\Index(name="log_date_lookup_idx", columns={"logged_at"}), @ORM\Index(name="log_user_lookup_idx", columns={"username"}), @ORM\Index(name="log_version_lookup_idx", columns={"object_id", "object_class", "version"})})
 * @ORM\Entity
 */
class ExtLogEntries
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
     * @ORM\Column(name="action", type="string", length=8, nullable=false)
     */
    private $action;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="logged_at", type="datetime", nullable=false)
     */
    private $loggedAt;

    /**
     * @var string|null
     *
     * @ORM\Column(name="object_id", type="string", length=64, nullable=true)
     */
    private $objectId;

    /**
     * @var string
     *
     * @ORM\Column(name="object_class", type="string", length=255, nullable=false)
     */
    private $objectClass;

    /**
     * @var int
     *
     * @ORM\Column(name="version", type="integer", nullable=false)
     */
    private $version;

    /**
     * @var array|null
     *
     * @ORM\Column(name="data", type="array", length=0, nullable=true)
     */
    private $data;

    /**
     * @var string|null
     *
     * @ORM\Column(name="username", type="string", length=255, nullable=true)
     */
    private $username;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setAction(string $action): self
    {
        $this->action = $action;

        return $this;
    }

    public function getLoggedAt(): ?\DateTimeInterface
    {
        return $this->loggedAt;
    }

    public function setLoggedAt(\DateTimeInterface $loggedAt): self
    {
        $this->loggedAt = $loggedAt;

        return $this;
    }

    public function getObjectId(): ?string
    {
        return $this->objectId;
    }

    public function setObjectId(?string $objectId): self
    {
        $this->objectId = $objectId;

        return $this;
    }

    public function getObjectClass(): ?string
    {
        return $this->objectClass;
    }

    public function setObjectClass(string $objectClass): self
    {
        $this->objectClass = $objectClass;

        return $this;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function setVersion(int $version): self
    {
        $this->version = $version;

        return $this;
    }

    public function getData(): ?array
    {
        return $this->data;
    }

    public function setData(?array $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }


}
