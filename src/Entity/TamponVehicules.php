<?php

namespace App\Entity;

use App\Repository\TamponVehiculesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TamponVehiculesRepository::class)]
class TamponVehicules
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $matricule = null;

    #[ORM\Column(nullable: true)]
    private ?float $kilometrerestant = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $checkassurance = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $checkvisite = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $checkvidange = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $porteeVehicule = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(?string $matricule): static
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getKilometrerestant(): ?float
    {
        return $this->kilometrerestant;
    }

    public function setKilometrerestant(?float $kilometrerestant): static
    {
        $this->kilometrerestant = $kilometrerestant;

        return $this;
    }

    public function getCheckassurance(): ?string
    {
        return $this->checkassurance;
    }

    public function setCheckassurance(?string $checkassurance): static
    {
        $this->checkassurance = $checkassurance;

        return $this;
    }

    public function getCheckvisite(): ?string
    {
        return $this->checkvisite;
    }

    public function setCheckvisite(?string $checkvisite): static
    {
        $this->checkvisite = $checkvisite;

        return $this;
    }

    public function getCheckvidange(): ?string
    {
        return $this->checkvidange;
    }

    public function setCheckvidange(?string $checkvidange): static
    {
        $this->checkvidange = $checkvidange;

        return $this;
    }

    public function getPorteeVehicule(): ?string
    {
        return $this->porteeVehicule;
    }

    public function setPorteeVehicule(?string $porteeVehicule): static
    {
        $this->porteeVehicule = $porteeVehicule;

        return $this;
    }
}
