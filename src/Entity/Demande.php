<?php

namespace App\Entity;

use DateTime;
use Doctrine\DBAL\Types\Types;
use Monolog\DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\DemandeRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: DemandeRepository::class)]
class Demande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $numDemande = null;

     #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $dateDemande = null;

/*     #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private $dateDemande; */


    #[ORM\Column(length: 255)]
    private string $objetMission = '';

/*     #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateDebutMission = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateFinMission = null; */

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private $dateDebutMission;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private $dateFinMission;

    #[ORM\ManyToMany(targetEntity: Commune::class)]
    #[ORM\JoinColumn(name: "commune_id", referencedColumnName: "id")]
    private $commune;


    protected Collection $communes;

    public function __construct()
    {
        $this->communes = new ArrayCollection();
    }


    #[ORM\Column(name: "lieuMission", type: "json")]
    private array $lieuMission;


    #[ORM\Column]
    private ?int $nbreParticipants = null;

    #[ORM\Column]
    private ?int $nbreVehicules = null;

    #[ORM\ManyToOne(inversedBy: 'demandes')]
    private ?User $demander = null;

    #[ORM\ManyToOne(inversedBy: 'demandesValidateurs')]
    private ?User $validateurStructure = null;

    #[ORM\ManyToOne(inversedBy: 'demandesTraiteur')]
    private ?User $traitePar = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deleteAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $statut = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $raisonRejetApprobation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $getRaisonRejetValidation = null;


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




    public function getObjetMission(): ?string
    {
        return $this->objetMission;
    }

    public function setObjetMission(string $objetMission): static
    {
        $this->objetMission = $objetMission;

        return $this;
    }


/* 
    public function getDateDemande(): ?\DateTimeImmutable
    {
        return $this->dateDemande;
    }

    public function setDateDemande(?\DateTimeImmutable $dateDemande): static
    {
        $this->dateDemande = $dateDemande;

        return $this;
    } */

/*     public function getDateDemande(): ?\DateTime
    {
        return $this->dateDemande;
    } */


    public function getDateDemande(): ?\DateTime
    {
        return $this->dateDemande ? \DateTime::createFromImmutable($this->dateDemande) : null;
    }

    public function setDateDemande(?\DateTimeImmutable $dateDemande): self
    {
        $this->dateDemande = $dateDemande;
        return $this;
    }


    public function getDateDebutMission(): ?\DateTime
    {
        return $this->dateDebutMission;
    }

    public function setDateDebutMission(?\DateTime $dateDebutMission): self
    {
        $this->dateDebutMission = $dateDebutMission;
        return $this;
    }

    public function getDateFinMission(): ?\DateTime
    {
        return $this->dateFinMission;
    }

    public function setDateFinMission(?\DateTime $dateFinMission): self
    {
        $this->dateFinMission = $dateFinMission;
        return $this;
    }






  /*   public function getDateDebutMission(): ?\DateTimeInterface
    {
        return $this->dateDebutMission;
    }

    public function setDateDebutMission(?\DateTimeInterface $dateDebutMission): static
    {
        $this->dateDebutMission = $dateDebutMission;

        return $this;
    }

    public function getDateFinMission(): ?\DateTimeInterface
    {
        return $this->dateFinMission;
    }

    public function setDateFinMission(?\DateTimeInterface $dateFinMission): static
    {
        $this->dateFinMission = $dateFinMission;

        return $this;
    } */
   
    public function getCommune(): ?Commune
    {
        return $this->commune;
    }

    public function setCommune(?Commune $commune): self
    {
        $this->commune = $commune;

        return $this;
    }

/*     public function removeLieu(Commune $commune): static
    {
        $this->commune->removeElement($commune);

        return $this;
    } */



    public function getCommunes(): Collection
    {
        return $this->communes;
    }   

    public function getLieuMission(): array
    {
        return $this->lieuMission;
    }
    

    public function setLieuMission(array $lieuMission): self
    {
        $this->lieuMission = $lieuMission;
    
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

    public function getDemander(): ?User
    {
        return $this->demander;
    }

    public function setDemander(?User $demander): static
    {
        $this->demander = $demander;

        return $this;
    }

    public function getValidateurStructure(): ?User
    {
        return $this->validateurStructure;
    }

    public function setValidateurStructure(?User $validateurStructure): static
    {
        $this->validateurStructure = $validateurStructure;

        return $this;
    }

    public function getTraitePar(): ?User
    {
        return $this->traitePar;
    }

    public function setTraitePar(?User $traitePar): static
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

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }


/*     public function formatDate(DateTimeImmutable $dateDemande, string $format): string
    {
        return $dateDemande->format($format);
    } */


/*     #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function validateDates(): void
    {
        $today = new \DateTime(); // Obtenez la date du jour
    
        if ($this->dateDebutMission && $this->dateFinMission) {
            if ($this->dateDebutMission < $today) {
                throw new \InvalidArgumentException('La date de début de la mission ne peut pas être antérieure à la date du jour.');
            }
            if ($this->dateFinMission > $this->dateDebutMission) {
                throw new \InvalidArgumentException('La date de début de la mission doit être antérieure ou égale à la date de fin de mission.');
            }
        }
    } */

public function getRaisonRejetApprobation(): ?string
{
    return $this->raisonRejetApprobation;
}

public function setRaisonRejetApprobation(?string $raisonRejetApprobation): static
{
    $this->raisonRejetApprobation = $raisonRejetApprobation;

    return $this;
}

public function getGetRaisonRejetValidation(): ?string
{
    return $this->getRaisonRejetValidation;
}

public function setGetRaisonRejetValidation(?string $getRaisonRejetValidation): static
{
    $this->getRaisonRejetValidation = $getRaisonRejetValidation;

    return $this;
}
}
