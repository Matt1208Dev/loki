<?php

namespace App\Entity;

use App\Repository\RentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RentRepository::class)
 */
class Rent
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Owner::class, inversedBy="rents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Owner;

    /**
     * @ORM\ManyToOne(targetEntity=Apartment::class, inversedBy="rents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Apartment;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startingDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endingDate;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $rentType;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $total;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPaid;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $settlementDate;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $deposit;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $comment;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOwner(): ?Owner
    {
        return $this->Owner;
    }

    public function setOwner(?Owner $Owner): self
    {
        $this->Owner = $Owner;

        return $this;
    }

    public function getApartment(): ?Apartment
    {
        return $this->Apartment;
    }

    public function setApartment(?Apartment $Apartment): self
    {
        $this->Apartment = $Apartment;

        return $this;
    }

    public function getStartingDate(): ?\DateTimeInterface
    {
        return $this->startingDate;
    }

    public function setStartingDate(\DateTimeInterface $startingDate): self
    {
        $this->startingDate = $startingDate;

        return $this;
    }

    public function getEndingDate(): ?\DateTimeInterface
    {
        return $this->endingDate;
    }

    public function setEndingDate(\DateTimeInterface $endingDate): self
    {
        $this->endingDate = $endingDate;

        return $this;
    }

    public function getRentType(): ?string
    {
        return $this->rentType;
    }

    public function setRentType(string $rentType): self
    {
        $this->rentType = $rentType;

        return $this;
    }

    public function getTotal(): ?string
    {
        return $this->total;
    }

    public function setTotal(string $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getIsPaid(): ?bool
    {
        return $this->isPaid;
    }

    public function setIsPaid(bool $isPaid): self
    {
        $this->isPaid = $isPaid;

        return $this;
    }

    public function getSettlementDate(): ?\DateTimeInterface
    {
        return $this->settlementDate;
    }

    public function setSettlementDate(?\DateTimeInterface $settlementDate): self
    {
        $this->settlementDate = $settlementDate;

        return $this;
    }

    public function getDeposit(): ?string
    {
        return $this->deposit;
    }

    public function setDeposit(string $deposit): self
    {
        $this->deposit = $deposit;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
