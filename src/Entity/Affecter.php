<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AffecterRepository;

#[ORM\Entity(repositoryClass: AffecterRepository::class)]
class Affecter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'affecters')]
    private ?Demande $demande = null;

    #[ORM\ManyToOne(inversedBy: 'affecters')]
    private ?Vehicule $vehicule = null;

    #[ORM\ManyToOne(inversedBy: 'affecters')]
    private ?Chauffeur $chauffeur = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]  
    private $dateDebutMission;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private $dateFinMission;


    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deleteAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $statut = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getdemande(): ?Demande
    {
        return $this->demande;
    }

    public function setdemande(?Demande $demande): static
    {
        $this->demande = $demande;

        return $this;
    }

    public function getvehicule(): ?Vehicule
    {
        return $this->vehicule;
    }

    public function setvehicule(?Vehicule $vehicule): static
    {
        $this->vehicule = $vehicule;

        return $this;
    }

    public function getchauffeur(): ?Chauffeur
    {
        return $this->chauffeur;
    }

    public function setchauffeur(?Chauffeur $chauffeur): static
    {
        $this->chauffeur = $chauffeur;

        return $this;
    }



    public function getDateDebutMission(): ?\DateTime
    {
        return $this->dateDebutMission;
    }

    public function setDateDebutMission(?\DateTime $dateDebutMission): self
    {
        $this->dateDebutMission = $dateDebutMission;
        return $this;
    }


    public function getDateFinMission(): ?\DateTime
    {
        return $this->dateFinMission;
    }

    public function setDateFinMission(?\DateTime $dateFinMission): self
    {
        $this->dateFinMission = $dateFinMission;
        return $this;
    }

    public function getDeleteAt(): ?\DateTimeImmutable
    {
        return $this->deleteAt;
    }

    public function setDeleteAt(?\DateTimeImmutable $deleteAt): static
    {
        $this->deleteAt = $deleteAt;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }
}
