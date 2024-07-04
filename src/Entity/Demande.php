<?php

namespace App\Entity;

use App\Repository\DemandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DemandeRepository::class)]
class Demande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $numDemande = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateDemande = null;

    #[ORM\Column(length: 255)]
    private ?string $objetMission = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateDebutMission = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateFinMission = null;

    /**
     * @var Collection<int, Commune>
     */
    #[ORM\ManyToMany(targetEntity: Commune::class, inversedBy: 'demandes')]
    private Collection $lieu;

    #[ORM\Column]
    private ?int $nbreParticipants = null;

    #[ORM\Column]
    private ?int $nbreVehicules = null;

    #[ORM\ManyToOne(inversedBy: 'demandes')]
    private ?Utilisateur $demander = null;

    #[ORM\ManyToOne(inversedBy: 'demandesValidateurs')]
    private ?Utilisateur $validateurStructure = null;

    #[ORM\ManyToOne(inversedBy: 'demandesTraiteur')]
    private ?Utilisateur $traitePar = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deleteAt = null;

    public function __construct()
    {
        $this->lieu = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumDemande(): ?string
    {
        return $this->numDemande;
    }

    public function setNumDemande(string $numDemande): static
    {
        $this->numDemande = $numDemande;

        return $this;
    }

    public function getDateDemande(): ?\DateTimeInterface
    {
        return $this->dateDemande;
    }

    public function setDateDemande(\DateTimeInterface $dateDemande): static
    {
        $this->dateDemande = $dateDemande;

        return $this;
    }

    public function getObjetMission(): ?string
    {
        return $this->objetMission;
    }

    public function setObjetMission(string $objetMission): static
    {
        $this->objetMission = $objetMission;

        return $this;
    }

    public function getDateDebutMission(): ?\DateTimeInterface
    {
        return $this->dateDebutMission;
    }

    public function setDateDebutMission(\DateTimeInterface $dateDebutMission): static
    {
        $this->dateDebutMission = $dateDebutMission;

        return $this;
    }

    public function getDateFinMission(): ?\DateTimeInterface
    {
        return $this->dateFinMission;
    }

    public function setDateFinMission(\DateTimeInterface $dateFinMission): static
    {
        $this->dateFinMission = $dateFinMission;

        return $this;
    }

    /**
     * @return Collection<int, Commune>
     */
    public function getLieu(): Collection
    {
        return $this->lieu;
    }

    public function addLieu(Commune $lieu): static
    {
        if (!$this->lieu->contains($lieu)) {
            $this->lieu->add($lieu);
        }

        return $this;
    }

    public function removeLieu(Commune $lieu): static
    {
        $this->lieu->removeElement($lieu);

        return $this;
    }

    public function getNbreParticipants(): ?int
    {
        return $this->nbreParticipants;
    }

    public function setNbreParticipants(int $nbreParticipants): static
    {
        $this->nbreParticipants = $nbreParticipants;

        return $this;
    }

    public function getNbreVehicules(): ?int
    {
        return $this->nbreVehicules;
    }

    public function setNbreVehicules(int $nbreVehicules): static
    {
        $this->nbreVehicules = $nbreVehicules;

        return $this;
    }

    public function getDemander(): ?Utilisateur
    {
        return $this->demander;
    }

    public function setDemander(?Utilisateur $demander): static
    {
        $this->demander = $demander;

        return $this;
    }

    public function getValidateurStructure(): ?Utilisateur
    {
        return $this->validateurStructure;
    }

    public function setValidateurStructure(?Utilisateur $validateurStructure): static
    {
        $this->validateurStructure = $validateurStructure;

        return $this;
    }

    public function getTraitePar(): ?Utilisateur
    {
        return $this->traitePar;
    }

    public function setTraitePar(?Utilisateur $traitePar): static
    {
        $this->traitePar = $traitePar;

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
