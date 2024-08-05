<?php

namespace App\Entity;

use App\Repository\TamponAffecterRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TamponAffecterRepository::class)]
class TamponAffecter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tamponMatricule = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tamponNomChauffeur = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tamponPrenomChauffeur = null;

    #[ORM\Column(nullable: true)]
    private ?float $tamponKilometrage = null;

    #[ORM\Column(nullable: true)]
    private ?int $tamponVehiculeId = null;

    #[ORM\Column(nullable: true)]
    private ?int $tamponChauffeurId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTamponMatricule(): ?string
    {
        return $this->tamponMatricule;
    }

    public function setTamponMatricule(?string $tamponMatricule): static
    {
        $this->tamponMatricule = $tamponMatricule;

        return $this;
    }

    public function getTamponNomChauffeur(): ?string
    {
        return $this->tamponNomChauffeur;
    }

    public function setTamponNomChauffeur(?string $tamponNomChauffeur): static
    {
        $this->tamponNomChauffeur = $tamponNomChauffeur;

        return $this;
    }

    public function getTamponPrenomChauffeur(): ?string
    {
        return $this->tamponPrenomChauffeur;
    }

    public function setTamponPrenomChauffeur(?string $tamponPrenomChauffeur): static
    {
        $this->tamponPrenomChauffeur = $tamponPrenomChauffeur;

        return $this;
    }

    public function getTamponKilometrage(): ?float
    {
        return $this->tamponKilometrage;
    }

    public function setTamponKilometrage(?float $tamponKilometrage): static
    {
        $this->tamponKilometrage = $tamponKilometrage;

        return $this;
    }

    public function getTamponVehiculeId(): ?int
    {
        return $this->tamponVehiculeId;
    }

    public function setTamponVehiculeId(?int $tamponVehiculeId): static
    {
        $this->tamponVehiculeId = $tamponVehiculeId;

        return $this;
    }

    public function getTamponChauffeurId(): ?int
    {
        return $this->tamponChauffeurId;
    }

    public function setTamponChauffeurId(?int $tamponChauffeurId): static
    {
        $this->tamponChauffeurId = $tamponChauffeurId;

        return $this;
    }
}
