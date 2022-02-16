<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=ServiceRepository::class)
 */
class Service
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="Le libellé est obligatoire.")
     * @Assert\Length(min=1, max=100, maxMessage="Le libellé ne doit pas dépasser 100 caractères.")
     */
    private $label;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     * @Assert\NotBlank(message="La saisie d'un prix est obligatoire.")
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity=RentRow::class, mappedBy="service")
     */
    private $rentRows;

    public function __construct()
    {
        $this->rentRows = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

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

    /**
     * @return Collection|RentRow[]
     */
    public function getRentRows(): Collection
    {
        return $this->rentRows;
    }

    public function addRentRow(RentRow $rentRow): self
    {
        if (!$this->rentRows->contains($rentRow)) {
            $this->rentRows[] = $rentRow;
            $rentRow->setService($this);
        }

        return $this;
    }

    public function removeRentRow(RentRow $rentRow): self
    {
        if ($this->rentRows->removeElement($rentRow)) {
            // set the owning side to null (unless already changed)
            if ($rentRow->getService() === $this) {
                $rentRow->setService(null);
            }
        }

        return $this;
    }
}
