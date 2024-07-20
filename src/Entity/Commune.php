<?php

namespace App\Entity;

use App\Repository\CommuneRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: CommuneRepository::class)]
#[Gedmo\SoftDeleteable(fieldName:"deleteAt", timeAware:false)]
#[UniqueEntity('libelleCommune')]
class Commune
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private string $libelleCommune = '';

    #[ORM\ManyToOne(inversedBy: 'communes')]
    private ?Departement $departement = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deleteAt = null;

    /**
     * @var Collection<int, Demande>
     */
    #[ORM\ManyToMany(targetEntity: Demande::class, mappedBy: 'lieu')]
    private Collection $demandes;

    public function __construct()
    {
        $this->demandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleCommune(): ?string
    {
        return $this->libelleCommune;
    }

    public function setLibelleCommune(string $libelleCommune): static
    {
        $this->libelleCommune = $libelleCommune;

        return $this;
    }

    public function getDepartement(): ?Departement
    {
        return $this->departement;
    }

    public function setDepartement(?Departement $departement): static
    {
        $this->departement = $departement;

        return $this;
    }

    public function getDeleteAt(): ?\DateTimeInterface
    {
        return $this->deleteAt;
    }

    public function setDeleteAt(?\DateTimeInterface $deleteAt): static
    {
        $this->deleteAt = $deleteAt;

        return $this;
    }

    /**
     * @return Collection<int, Demande>
     */
    public function getDemandes(): Collection
    {
        return $this->demandes;
    }

    // public function addDemande(Demande $demande): static
    // {
    //     if (!$this->demandes->contains($demande)) {
    //         $this->demandes->add($demande);
    //         $demande->addLieu($this);
    //     }

    //     return $this;
    // }

    // public function removeDemande(Demande $demande): static
    // {
    //     if ($this->demandes->removeElement($demande)) {
    //         $demande->removeLieu($this);
    //     }

    //     return $this;
    // }
}
