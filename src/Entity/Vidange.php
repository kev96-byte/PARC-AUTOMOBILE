<?php

namespace App\Entity;

use App\Repository\VidangeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: VidangeRepository::class)]
#[Vich\Uploadable()]
#[UniqueEntity(
    fields: ['vehicule', 'dateVidange'],
    message: 'Une vidange pour ce véhicule avec cette date de début existe déjà.'
)]
class Vidange
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'vidanges')]
    private ?Vehicule $vehicule = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank]
    private ?\DateTimeInterface $dateVidange = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $valeurCompteurKilometrage = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pieceVidange = null;

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

    public function getDateVidange(): ?\DateTimeInterface
    {
        return $this->dateVidange;
    }

    public function setDateVidange(\DateTimeInterface $dateVidange): static
    {
        $this->dateVidange = $dateVidange;

        return $this;
    }

    public function getValeurCompteurKilometrage(): ?float
    {
        return $this->valeurCompteurKilometrage;
    }

    public function setValeurCompteurKilometrage(float $valeurCompteurKilometrage): static
    {
        $this->valeurCompteurKilometrage = $valeurCompteurKilometrage;

        return $this;
    }

    public function getPieceVidange(): ?string
    {
        return $this->pieceVidange;
    }

    public function setPieceVidange(?string $pieceVidange): static
    {
        $this->pieceVidange = $pieceVidange;

        return $this;
    }
}
