<?php

namespace App\Entity;

use App\Repository\FilialesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FilialesRepository::class)]
class Filiales
{
    public function __toString(){
        return $this->Nom;
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nom = null;

    #[ORM\OneToMany(mappedBy: 'Filiale', targetEntity: Contact::class)]
    private Collection $contacts;

    #[ORM\OneToMany(mappedBy: 'Prospects', targetEntity: Contact::class)]
    private Collection $contactsProspect;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ID_Avensys = null;

    public function __construct()
    {
        $this->contacts = new ArrayCollection();
        $this->contactsProspect = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): static
    {
        $this->Nom = $Nom;

        return $this;
    }

    /**
     * @return Collection<int, Contact>
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact): static
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts->add($contact);
            $contact->setFiliale($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): static
    {
        if ($this->contacts->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getFiliale() === $this) {
                $contact->setFiliale(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Contact>
     */
    public function getContactsProspect(): Collection
    {
        return $this->contactsProspect;
    }

    public function addContactsProspect(Contact $contactsProspect): static
    {
        if (!$this->contactsProspect->contains($contactsProspect)) {
            $this->contactsProspect->add($contactsProspect);
            $contactsProspect->setProspects($this);
        }

        return $this;
    }

    public function removeContactsProspect(Contact $contactsProspect): static
    {
        if ($this->contactsProspect->removeElement($contactsProspect)) {
            // set the owning side to null (unless already changed)
            if ($contactsProspect->getProspects() === $this) {
                $contactsProspect->setProspects(null);
            }
        }

        return $this;
    }

    public function getIDAvensys(): ?string
    {
        return $this->ID_Avensys;
    }

    public function setIDAvensys(?string $ID_Avensys): static
    {
        $this->ID_Avensys = $ID_Avensys;

        return $this;
    }
}
