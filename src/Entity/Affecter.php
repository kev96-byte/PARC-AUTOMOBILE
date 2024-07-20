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
    private ?Demande $demandeId = null;

    #[ORM\ManyToOne(inversedBy: 'affecters')]
    private ?Vehicule $vehiculeId = null;

    #[ORM\ManyToOne(inversedBy: 'affecters')]
    private ?Chauffeur $chauffeurId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDemandeId(): ?Demande
    {
        return $this->demandeId;
    }

    public function setDemandeId(?Demande $demandeId): static
    {
        $this->demandeId = $demandeId;

        return $this;
    }

    public function getVehiculeId(): ?Vehicule
    {
        return $this->vehiculeId;
    }

    public function setVehiculeId(?Vehicule $vehiculeId): static
    {
        $this->vehiculeId = $vehiculeId;

        return $this;
    }

    public function getChauffeurId(): ?Chauffeur
    {
        return $this->chauffeurId;
    }

    public function setChauffeurId(?Chauffeur $chauffeurId): static
    {
        $this->chauffeurId = $chauffeurId;

        return $this;
    }
}
