<?php

namespace App\Entity;

use App\Repository\AffecterRepository;
use Doctrine\ORM\Mapping as ORM;

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

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deleteAt = null;

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

    public function getDeleteAt(): ?\DateTimeImmutable
    {
        return $this->deleteAt;
    }

    public function setDeleteAt(?\DateTimeImmutable $deleteAt): static
    {
        $this->deleteAt = $deleteAt;

        return $this;
    }
}
