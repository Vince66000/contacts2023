<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nom = null;

    #[ORM\Column(length: 40, nullable: true)]
    private ?string $Civilite = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $Type = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $Adresse = null;

    #[ORM\Column(length: 20, nullable: true)]
    #[Assert\Regex(
        pattern: '/^[0-9]{5}$/',
        message: 'Le code postal doit être composé de 5 chiffres.'
    )]
    private ?string $CodePostal = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Ville = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $Telephone = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Assert\Email(
        message: 'Ce champs doit contir un email valide.',
    )]
    private ?string $Email = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $MotifContact = null;



    #[ORM\Column(length: 100, nullable: true)]
    private ?string $Origine = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $Notes = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Suites = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $Statut = null;

    #[ORM\ManyToOne(inversedBy: 'contacts')]
    private ?Filiales $Filiale = null;

    #[ORM\ManyToOne(inversedBy: 'contactsProspect')]
    private ?Filiales $Prospects = null;

    #[ORM\ManyToOne(inversedBy: 'contacts' )]
    private ?Assistantes $Assistante = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Intermediaire = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_update = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $AdresseExp = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $CodePostalExp = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $VilleExp = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $AdresseInter = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $CodePostalInter = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $VilleInter = null;


    public function __construct() {
        $this->Date = new \DateTime();
        $this->date_update = new \DateTime();
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

    public function getCivilite(): ?string
    {
        return $this->Civilite;
    }

    public function setCivilite(?string $Civilite): static
    {
        $this->Civilite = $Civilite;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->Type;
    }

    public function setType(?string $Type): static
    {
        $this->Type = $Type;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->Adresse;
    }

    public function setAdresse(?string $Adresse): static
    {
        $this->Adresse = $Adresse;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->CodePostal;
    }

    public function setCodePostal(?string $CodePostal): static
    {
        $this->CodePostal = $CodePostal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->Ville;
    }

    public function setVille(?string $Ville): static
    {
        $this->Ville = $Ville;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->Telephone;
    }

    public function setTelephone(?string $Telephone): static
    {
        $this->Telephone = $Telephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(?string $Email): static
    {
        $this->Email = $Email;

        return $this;
    }

    public function getMotifContact(): ?string
    {
        return $this->MotifContact;
    }

    public function setMotifContact(?string $MotifContact): static
    {
        $this->MotifContact = $MotifContact;

        return $this;
    }

//    public function getAdresseExpertise(): ?string
//    {
//        return $this->AdresseExpertise;
//    }
//
//    public function setAdresseExpertise(?string $AdresseExpertise): static
//    {
//        $this->AdresseExpertise = $AdresseExpertise;
//
//        return $this;
//    }

    public function getOrigine(): ?string
    {
        return $this->Origine;
    }

    public function setOrigine(?string $Origine): static
    {
        $this->Origine = $Origine;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->Notes;
    }

    public function setNotes(?string $Notes): static
    {
        $this->Notes = $Notes;

        return $this;
    }

    public function getSuites(): ?string
    {
        return $this->Suites;
    }

    public function setSuites(?string $Suites): static
    {
        $this->Suites = $Suites;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->Statut;
    }

    public function setStatut(?string $Statut): static
    {
        $this->Statut = $Statut;

        return $this;
    }

    public function getFiliale(): ?Filiales
    {
        return $this->Filiale;
    }

    public function setFiliale(?Filiales $Filiale): static
    {
        $this->Filiale = $Filiale;

        return $this;
    }

    public function getProspects(): ?Filiales
    {
        return $this->Prospects;
    }

    public function setProspects(?Filiales $Prospects): static
    {
        $this->Prospects = $Prospects;

        return $this;
    }

    public function getAssistante(): ?Assistantes
    {
        return $this->Assistante;
    }

    public function setAssistante(?Assistantes $Assistante): static
    {
        $this->Assistante = $Assistante;

        return $this;
    }


    public function getIntermediaire(): ?string
    {
        return $this->Intermediaire;
    }

    public function setIntermediaire(?string $Intermediaire): static
    {
        $this->Intermediaire = $Intermediaire;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): static
    {
        $this->Date = $Date;

        return $this;
    }

    public function getDateUpdate(): ?\DateTimeInterface
    {
        return $this->date_update;
    }

    public function setDateUpdate(\DateTimeInterface $date_update): static
    {
        $this->date_update = $date_update;

        return $this;
    }

    public function getAdresseExp(): ?string
    {
        return $this->AdresseExp;
    }

    public function setAdresseExp(?string $AdresseExp): static
    {
        $this->AdresseExp = $AdresseExp;

        return $this;
    }

    public function getCodePostalExp(): ?string
    {
        return $this->CodePostalExp;
    }

    public function setCodePostalExp(?string $CodePostalExp): static
    {
        $this->CodePostalExp = $CodePostalExp;

        return $this;
    }

    public function getVilleExp(): ?string
    {
        return $this->VilleExp;
    }

    public function setVilleExp(?string $VilleExp): static
    {
        $this->VilleExp = $VilleExp;

        return $this;
    }

    public function getAdresseInter(): ?string
    {
        return $this->AdresseInter;
    }

    public function setAdresseInter(?string $AdresseInter): static
    {
        $this->AdresseInter = $AdresseInter;

        return $this;
    }

    public function getCodePostalInter(): ?string
    {
        return $this->CodePostalInter;
    }

    public function setCodePostalInter(?string $CodePostalInter): static
    {
        $this->CodePostalInter = $CodePostalInter;

        return $this;
    }

    public function getVilleInter(): ?string
    {
        return $this->VilleInter;
    }

    public function setVilleInter(?string $VilleInter): static
    {
        $this->VilleInter = $VilleInter;

        return $this;
    }


}
