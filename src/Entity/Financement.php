<?php

namespace App\Entity;

use App\Repository\FinancementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FinancementRepository::class)]
class Financement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelleFinancement = null;

    #[ORM\Column(length: 255)]
    private ?string $typeFinancementent = null;

    /**
     * @var Collection<int, Vehicule>
     */
    #[ORM\OneToMany(targetEntity: Vehicule::class, mappedBy: 'financement')]
    private Collection $vehicule;

    public function __construct()
    {
        $this->vehicule = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleFinancement(): ?string
    {
        return $this->libelleFinancement;
    }

    public function setLibelleFinancement(string $libelleFinancement): static
    {
        $this->libelleFinancement = $libelleFinancement;

        return $this;
    }

    public function getTypeFinancementent(): ?string
    {
        return $this->typeFinancementent;
    }

    public function setTypeFinancementent(string $typeFinancementent): static
    {
        $this->typeFinancementent = $typeFinancementent;

        return $this;
    }

    /**
     * @return Collection<int, Vehicule>
     */
    public function getVehicule(): Collection
    {
        return $this->vehicule;
    }

    public function addVehicule(Vehicule $vehicule): static
    {
        if (!$this->vehicule->contains($vehicule)) {
            $this->vehicule->add($vehicule);
            $vehicule->setFinancement($this);
        }

        return $this;
    }

    public function removeVehicule(Vehicule $vehicule): static
    {
        if ($this->vehicule->removeElement($vehicule)) {
            // set the owning side to null (unless already changed)
            if ($vehicule->getFinancement() === $this) {
                $vehicule->setFinancement(null);
            }
        }

        return $this;
    }
}
