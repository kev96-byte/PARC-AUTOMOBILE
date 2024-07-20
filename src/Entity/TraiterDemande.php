<?php

namespace App\Entity;

use App\Repository\TraiterDemandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TraiterDemandeRepository::class)]
class TraiterDemande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Demande>
     */
    #[ORM\ManyToMany(targetEntity: Demande::class, inversedBy: 'traiterDemandes')]
    private Collection $demandeId;

    /**
     * @var Collection<int, Chauffeur>
     */
    #[ORM\ManyToMany(targetEntity: Chauffeur::class, inversedBy: 'traiterDemandes')]
    private Collection $chauffeurId;

    /**
     * @var Collection<int, Vehicule>
     */
    #[ORM\ManyToMany(targetEntity: Vehicule::class, inversedBy: 'traiterDemandes')]
    private Collection $vehiculeId;

    public function __construct()
    {
        $this->demandeId = new ArrayCollection();
        $this->chauffeurId = new ArrayCollection();
        $this->vehiculeId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Demande>
     */
    public function getDemandeId(): Collection
    {
        return $this->demandeId;
    }

    public function addDemandeId(Demande $demandeId): static
    {
        if (!$this->demandeId->contains($demandeId)) {
            $this->demandeId->add($demandeId);
        }

        return $this;
    }

    public function removeDemandeId(Demande $demandeId): static
    {
        $this->demandeId->removeElement($demandeId);

        return $this;
    }

    /**
     * @return Collection<int, Chauffeur>
     */
    public function getChauffeurId(): Collection
    {
        return $this->chauffeurId;
    }

    public function addChauffeurId(Chauffeur $chauffeurId): static
    {
        if (!$this->chauffeurId->contains($chauffeurId)) {
            $this->chauffeurId->add($chauffeurId);
        }

        return $this;
    }

    public function removeChauffeurId(Chauffeur $chauffeurId): static
    {
        $this->chauffeurId->removeElement($chauffeurId);

        return $this;
    }

    /**
     * @return Collection<int, Vehicule>
     */
    public function getVehiculeId(): Collection
    {
        return $this->vehiculeId;
    }

    public function addVehiculeId(Vehicule $vehiculeId): static
    {
        if (!$this->vehiculeId->contains($vehiculeId)) {
            $this->vehiculeId->add($vehiculeId);
        }

        return $this;
    }

    public function removeVehiculeId(Vehicule $vehiculeId): static
    {
        $this->vehiculeId->removeElement($vehiculeId);

        return $this;
    }
}
