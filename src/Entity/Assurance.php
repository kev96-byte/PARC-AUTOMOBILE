<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Validator\DatesConstraint;
use App\Repository\AssuranceRepository;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


#[ORM\Entity(repositoryClass: AssuranceRepository::class)]
#[Vich\Uploadable()]
#[UniqueEntity(
    fields: ['vehicule', 'dateDebutAssurance'],
    message: 'Une assurance pour ce véhicule avec cette date de début existe déjà.'
)]

class Assurance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'assurances')]
    private ?Vehicule $vehicule = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank]
    private ?\DateTimeInterface $dateDebutAssurance = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank]
    private ?\DateTimeInterface $dateFinAssurance = null;


    #[Vich\UploadableField(mapping : "assurances", fileNameProperty : "pieceAssurance")]  
    private $pieceAssuranceFile;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pieceAssurance = null;


    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deleteAt = null;

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

    public function getDateDebutAssurance(): ?\DateTimeInterface
    {
        return $this->dateDebutAssurance;
    }

    public function setDateDebutAssurance(\DateTimeInterface $dateDebutAssurance): static
    {
        $this->dateDebutAssurance = $dateDebutAssurance;

        return $this;
    }

    public function getDateFinAssurance(): ?\DateTimeInterface
    {
        return $this->dateFinAssurance;
    }

    public function setDateFinAssurance(\DateTimeInterface $dateFinAssurance): static
    {
        $this->dateFinAssurance = $dateFinAssurance;

        return $this;
    }

    

    public function setPieceAssuranceFile(?File $file = null): void
    {
        $this->pieceAssuranceFile = $file;

        if (null !== $file) {
            $this->deleteAt = new \DateTimeImmutable();
        }
    }

    public function getPieceAssuranceFile(): ?File
    {
        return $this->pieceAssuranceFile;
    }




    public function getPieceAssurance(): ?string
    {
        return $this->pieceAssurance;
    }

    public function setPieceAssurance(?string $pieceAssurance): static
    {
        $this->pieceAssurance = $pieceAssurance;

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
}
