<?php

namespace App\Entity;

use App\Repository\VisiteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: VisiteRepository::class)]
#[Vich\Uploadable()]
#[UniqueEntity(
    fields: ['vehiculeId', 'dateDebutVisite'],
    message: 'Une visite pour ce véhicule avec cette date de début existe déjà.'
)]
class Visite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'visites')]
    private ?Vehicule $vehiculeId = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank]
    private ?\DateTimeInterface $dateDebutVisite = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank]
    private ?\DateTimeInterface $dateFinVisite = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pieceVisite = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDateDebutVisite(): ?\DateTimeInterface
    {
        return $this->dateDebutVisite;
    }

    public function setDateDebutVisite(\DateTimeInterface $dateDebutVisite): static
    {
        $this->dateDebutVisite = $dateDebutVisite;

        return $this;
    }

    public function getDateFinVisite(): ?\DateTimeInterface
    {
        return $this->dateFinVisite;
    }

    public function setDateFinVisite(\DateTimeInterface $dateFinVisite): static
    {
        $this->dateFinVisite = $dateFinVisite;

        return $this;
    }

    public function getPieceVisite(): ?string
    {
        return $this->pieceVisite;
    }

    public function setPieceVisite(?string $pieceVisite): static
    {
        $this->pieceVisite = $pieceVisite;

        return $this;
    }
}
