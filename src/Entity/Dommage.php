<?php
namespace App\Entity;

use App\Repository\DommageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DommageRepository::class)]
class Dommage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'dommages')]
    private ?Vehicule $vehicule = null;

    #[ORM\ManyToOne(inversedBy: 'dommages')]
    private ?Chauffeur $chauffeur = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $typeDommage = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateDommage = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deleteAt = null;

    #[ORM\Column(type: 'boolean')]
    private bool $repare = false;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $dateReparation = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $observation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVehicule(): ?Vehicule
    {
        return $this->vehicule;
    }

    public function setVehicule(?Vehicule $vehicule): static
    {
        $this->vehicule = $vehicule;
        return $this;
    }

    public function getChauffeur(): ?Chauffeur
    {
        return $this->chauffeur;
    }

    public function setChauffeur(?Chauffeur $chauffeur): static
    {
        $this->chauffeur = $chauffeur;
        return $this;
    }

    public function getTypeDommage(): ?string
    {
        return $this->typeDommage;
    }

    public function setTypeDommage(?string $typeDommage): static
    {
        $this->typeDommage = $typeDommage;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getDateDommage(): ?\DateTimeInterface
    {
        return $this->dateDommage;
    }

    public function setDateDommage(?\DateTimeInterface $dateDommage): static
    {
        $this->dateDommage = $dateDommage;
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

    public function isRepare(): bool
    {
        return $this->repare;
    }

    public function setRepare(bool $repare): static
    {
        $this->repare = $repare;
        return $this;
    }

    public function getDateReparation(): ?\DateTimeInterface
    {
        return $this->dateReparation;
    }

    public function setDateReparation(?\DateTimeInterface $dateReparation): static
    {
        $this->dateReparation = $dateReparation;
        return $this;
    }

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation(?string $observation): static
    {
        $this->observation = $observation;
        return $this;
    }
}
