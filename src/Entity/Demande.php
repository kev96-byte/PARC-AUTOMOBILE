<?php

namespace App\Entity;

use DateTime;
use Doctrine\DBAL\Types\Types;
use Monolog\DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\DemandeRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\DatesConstraint;

#[ORM\Entity(repositoryClass: DemandeRepository::class)]
#[DatesConstraint]
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
    #[Assert\NotBlank]
    private $dateDebutMission;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Assert\NotBlank]
    private $dateFinMission;

    #[ORM\ManyToMany(targetEntity: Commune::class)]
    #[ORM\JoinColumn(name: "commune_id", referencedColumnName: "id")]
    private $commune;


    protected Collection $communes;

    public function __construct()
    {
        $this->communes = new ArrayCollection();
        $this->dateDebutMission = new \DateTime();
        $this->dateFinMission = new \DateTime();
        $this->traiterDemandes = new ArrayCollection();
        $this->affecters = new ArrayCollection();
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

 

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $dateApprobation = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $dateTraitement = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $observations = null;

    /**
     * @var Collection<int, TraiterDemande>
     */
    #[ORM\ManyToMany(targetEntity: TraiterDemande::class, mappedBy: 'demandeId')]
    private Collection $traiterDemandes;

    /**
     * @var Collection<int, Affecter>
     */
    #[ORM\OneToMany(targetEntity: Affecter::class, mappedBy: 'demandeId')]
    private Collection $affecters;


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

public function getDateApprobation(): ?\DateTimeImmutable
{
    return $this->dateApprobation;
}

public function setDateApprobation(?\DateTimeImmutable $dateApprobation): static
{
    $this->dateApprobation = $dateApprobation;

    return $this;
}

public function getDateTraitement(): ?\DateTimeImmutable
{
    return $this->dateTraitement;
}

public function setDateTraitement(?\DateTimeImmutable $dateTraitement): static
{
    $this->dateTraitement = $dateTraitement;

    return $this;
}

public function getObservations(): ?string
{
    return $this->observations;
}

public function setObservations(?string $observations): static
{
    $this->observations = $observations;

    return $this;
}

/**
 * @return Collection<int, TraiterDemande>
 */
public function getTraiterDemandes(): Collection
{
    return $this->traiterDemandes;
}

public function addTraiterDemande(TraiterDemande $traiterDemande): static
{
    if (!$this->traiterDemandes->contains($traiterDemande)) {
        $this->traiterDemandes->add($traiterDemande);
        $traiterDemande->addDemandeId($this);
    }

    return $this;
}

public function removeTraiterDemande(TraiterDemande $traiterDemande): static
{
    if ($this->traiterDemandes->removeElement($traiterDemande)) {
        $traiterDemande->removeDemandeId($this);
    }

    return $this;
}

/**
 * @return Collection<int, Affecter>
 */
public function getAffecters(): Collection
{
    return $this->affecters;
}

public function addAffecter(Affecter $affecter): static
{
    if (!$this->affecters->contains($affecter)) {
        $this->affecters->add($affecter);
        $affecter->setDemandeId($this);
    }

    return $this;
}

public function removeAffecter(Affecter $affecter): static
{
    if ($this->affecters->removeElement($affecter)) {
        // set the owning side to null (unless already changed)
        if ($affecter->getDemandeId() === $this) {
            $affecter->setDemandeId(null);
        }
    }

    return $this;
}
}
