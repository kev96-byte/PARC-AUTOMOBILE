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
    private ?User $traiterPar = null;

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
     * @var Collection<int, Affecter>
     */
    #[ORM\OneToMany(targetEntity: Affecter::class, mappedBy: 'demande')]
    private Collection $affecters;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateEffectiveFinMission = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateFinalisationDemande = null;

    #[ORM\ManyToOne(inversedBy: 'demandesfinaliserpar')]
    private ?User $finaliserPar = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $referenceNoteDeService = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateSignatureNoteDeService = null;

    #[ORM\ManyToOne(inversedBy: 'demandes')]
    private ?Structure $structure = null;

    #[ORM\ManyToOne(inversedBy: 'demandes')]
    private ?Institution $institution = null;


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

    public function getTraiterPar(): ?User
    {
        return $this->traiterPar;
    }

    public function setTraiterPar(?User $traiterPar): static
    {
        $this->traiterPar = $traiterPar;

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
        $affecter->setDemande($this);
    }

    return $this;
}

public function removeAffecter(Affecter $affecter): static
{
    if ($this->affecters->removeElement($affecter)) {
        // set the owning side to null (unless already changed)
        if ($affecter->getDemande() === $this) {
            $affecter->setDemande(null);
        }
    }

    return $this;
}

public function getDateEffectiveFinMission(): ?\DateTimeInterface
{
    return $this->dateEffectiveFinMission;
}

public function setDateEffectiveFinMission(?\DateTimeInterface $dateEffectiveFinMission): static
{
    $this->dateEffectiveFinMission = $dateEffectiveFinMission;

    return $this;
}

public function getDateFinalisationDemande(): ?\DateTimeInterface
{
    return $this->dateFinalisationDemande;
}

public function setDateFinalisationDemande(?\DateTimeInterface $dateFinalisationDemande): static
{
    $this->dateFinalisationDemande = $dateFinalisationDemande;

    return $this;
}

public function getFinaliserPar(): ?User
{
    return $this->finaliserPar;
}

public function setFinaliserPar(?User $finaliserPar): static
{
    $this->finaliserPar = $finaliserPar;

    return $this;
}

public function getReferenceNoteDeService(): ?string
{
    return $this->referenceNoteDeService;
}

public function setReferenceNoteDeService(string $referenceNoteDeService): static
{
    $this->referenceNoteDeService = $referenceNoteDeService;

    return $this;
}

public function getDateSignatureNoteDeService(): ?\DateTimeInterface
{
    return $this->dateSignatureNoteDeService;
}

public function setDateSignatureNoteDeService(?\DateTimeInterface $dateSignatureNoteDeService): static
{
    $this->dateSignatureNoteDeService = $dateSignatureNoteDeService;

    return $this;
}

public function getStructure(): ?Structure
{
    return $this->structure;
}

public function setStructure(?Structure $structure): static
{
    $this->structure = $structure;

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
}
