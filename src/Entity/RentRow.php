<?php

namespace App\Entity;

use App\Repository\RentRowRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RentRowRepository::class)
 */
class RentRow
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Service::class, inversedBy="rentRows")
     * @ORM\JoinColumn(nullable=false)
     */
    private $service;

    /**
     * @ORM\ManyToOne(targetEntity=Rent::class, inversedBy="rentRows")
     * @ORM\JoinColumn(nullable=false)
     */
    private $rent;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $price;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $totalRow;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $serviceLabel;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function getRent(): ?Rent
    {
        return $this->rent;
    }

    public function setRent(?Rent $rent): self
    {
        $this->rent = $rent;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getTotalRow(): ?string
    {
        return $this->totalRow;
    }

    public function setTotalRow(string $totalRow): self
    {
        $this->totalRow = $totalRow;

        return $this;
    }

    public function getServiceLabel(): ?string
    {
        return $this->serviceLabel;
    }

    public function setServiceLabel(?string $serviceLabel): self
    {
        $this->serviceLabel = $serviceLabel;

        return $this;
    }
}
