<?php

namespace App\Entity;

use App\Repository\OwnerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=OwnerRepository::class)
 */
class Owner
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Le prénom est obligatoire")
     * @Assert\Length(min=1, max=50, maxMessage="Le prénom ne doit pas excéder 50 caractères")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Le nom est obligatoire")
     * @Assert\Length(min=1, max=50, maxMessage="Le nom ne doit pas excéder 50 caractères")
     * caractères")
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank(message="L'adresse est obligatoire")
     * @Assert\Length(min=1, max=80, maxMessage="L'adresse ne doit pas excéder 150 caractères")
     */
    private $street;

    /**
     * @ORM\Column(type="string", length=80, nullable=true)
     * @Assert\NotBlank(message="La ville est obligatoire")
     * @Assert\Length(min=1, max=50, maxMessage="Le nom de la ville ne doit pas excéder 80 caractères")
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=6, nullable=true)
     * @Assert\NotBlank(message="Le code postal est obligatoire")
     * @Assert\Regex("/^((0[1-9])|([1-8][0-9])|(9[0-8])|(2A)|(2B))[0-9]{3}$/", message="Vous n'avez pas entré un code postal valide")
     */
    private $zip;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Assert\NotBlank(message="Le numéro de téléphone est obligatoire")
     * @Assert\Regex("/^0[1-9]([-. ]?[0-9]{2}){4}$/", message="Le numéro de téléphone n'est pas valide")
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Regex("/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,4})$/", message="Le mail n'est pas valide")
     * @Assert\Length(max=255, maxMessage="L'adresse mail ne doit pas excéder 255 caractères")
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max=255, maxMessage="Le commentaire ne doit pas excéder 255 caractères")
     */
    private $comment;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=Apartment::class, mappedBy="owner")
     */
    private $apartments;

    /**
     * @ORM\OneToMany(targetEntity=Rent::class, mappedBy="Owner")
     */
    private $rents;

    /**
     * @ORM\Column(type="boolean")
     */
    private $retired;

    public function __construct()
    {
        $this->apartments = new ArrayCollection();
        $this->rents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(?string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function setZip(?string $zip): self
    {
        $this->zip = $zip;

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

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(?string $mail): self
    {
        $this->mail = $mail;

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

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|Apartment[]
     */
    public function getApartments(): Collection
    {
        return $this->apartments;
    }

    public function addApartment(Apartment $apartment): self
    {
        if (!$this->apartments->contains($apartment)) {
            $this->apartments[] = $apartment;
            $apartment->setOwner($this);
        }

        return $this;
    }

    public function removeApartment(Apartment $apartment): self
    {
        if ($this->apartments->removeElement($apartment)) {
            // set the owning side to null (unless already changed)
            if ($apartment->getOwner() === $this) {
                $apartment->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Rent[]
     */
    public function getRents(): Collection
    {
        return $this->rents;
    }

    public function addRent(Rent $rent): self
    {
        if (!$this->rents->contains($rent)) {
            $this->rents[] = $rent;
            $rent->setOwner($this);
        }

        return $this;
    }

    public function removeRent(Rent $rent): self
    {
        if ($this->rents->removeElement($rent)) {
            // set the owning side to null (unless already changed)
            if ($rent->getOwner() === $this) {
                $rent->setOwner(null);
            }
        }

        return $this;
    }

    public function getRetired(): ?bool
    {
        return $this->retired;
    }

    public function setRetired(bool $retired): self
    {
        $this->retired = $retired;

        return $this;
    }
}
