<?php

namespace App\Entity;

use App\Repository\ChauffeurRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;


#[Gedmo\SoftDeleteable(fieldName:"deleteAt", timeAware:false)]
#[UniqueEntity(fields: ['matriculeChauffeur', 'numPermis'])]
#[ORM\Entity(repositoryClass: ChauffeurRepository::class)]
class Chauffeur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private string $nomChauffeur = '';

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private string $prenomChauffeur = '';


    #[ORM\Column(length: 16, nullable: true)]
    #[Assert\Regex(
        pattern: '/^(\+229)?\s?(20|21|22|23|40|41|42|43|44|45|50|51|52|53|54|55|56|57|58|59|60|62|63|64|65|66|67|68|69|90|91|92|93|94|95|96|97|98|99)\s?\d{2}\s?\d{2}\s?\d{2}$/',
        match: true,
        message: 'Numéro de téléphone incorrecte',
    )]  
    private ?string $telephoneChauffeur = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private string $numPermis = '';

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $etatChauffeur = null;

    #[ORM\ManyToOne(inversedBy: 'chauffeur')]
    private ?Institution $institution = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deleteAt = null;

    #[ORM\Column(length: 255)]
    private string $matriculeChauffeur = '';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomChauffeur(): ?string
    {
        return $this->nomChauffeur;
    }

    public function setNomChauffeur(string $nomChauffeur): static
    {
        $this->nomChauffeur = $nomChauffeur;

        return $this;
    }

    public function getPrenomChauffeur(): ?string
    {
        return $this->prenomChauffeur;
    }

    public function setPrenomChauffeur(string $prenomChauffeur): static
    {
        $this->prenomChauffeur = $prenomChauffeur;

        return $this;
    }

    public function getTelephoneChauffeur(): ?string
    {
        return $this->telephoneChauffeur;
    }

    public function setTelephoneChauffeur(?string $telephoneChauffeur): static
    {
        $this->telephoneChauffeur = $telephoneChauffeur;

        return $this;
    }

    public function getNumPermis(): ?string
    {
        return $this->numPermis;
    }

    public function setNumPermis(string $numPermis): static
    {
        $this->numPermis = $numPermis;

        return $this;
    }

    public function getEtatChauffeur(): ?string
    {
        return $this->etatChauffeur;
    }

    public function setEtatChauffeur(?string $etatChauffeur): static
    {
        $this->etatChauffeur = $etatChauffeur;

        return $this;
    }

    public function getInstitution(): ?Institution
    {
        return $this->institution;
    }

    public function setInstitution(?Institution $institution): static
    {
        $this->institution = $institution;

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

    public function getMatriculeChauffeur(): ?string
    {
        return $this->matriculeChauffeur;
    }

    public function setMatriculeChauffeur(string $matriculeChauffeur): static
    {
        $this->matriculeChauffeur = $matriculeChauffeur;

        return $this;
    }
}
