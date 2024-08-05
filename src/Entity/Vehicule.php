<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\VehiculeRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\HasLifecycleCallbacks]
#[Vich\Uploadable()]
#[ORM\Entity(repositoryClass: VehiculeRepository::class)]
#[UniqueEntity('matricule')]
class Vehicule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('vehicule_list')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Regex(
        pattern: '/^[A-Z]{2,3} \d{3,4} RB$/',
        match: true,
        message: "Le matricule doit être sur 10 positions, avec les deux premiers caractères en lettres majuscules, suivis d'un espace, quatre chiffres, un autre espace, et les deux dernières positions doivent être 'RB'. Exemple : BV 1100 RB",
    )]  
    #[Groups('vehicule_list')]
    private string $matricule = '';

    #[ORM\Column(length: 255)]
    private string $numeroChassis = '';

/*     #[ORM\Column(length: 255)]
    private ?string $marque = null; */

    #[ORM\ManyToOne(inversedBy: 'vehicules')]
    private ?Marque $marque = null;

    #[ORM\Column(length: 255)]
    private string $modele = '';

    #[ORM\Column]
    #[Assert\NotBlank]
    private ?int $nbrePlace = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $etat = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateAcquisition = null;

    #[ORM\Column(nullable: true)]
    private ?float $valeurAcquisition = null;

    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank]
    private ?float $kilometrageInitial = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateReception = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateMiseEnCirculation = null;

    #[ORM\Column(nullable: true)]
    private ?bool $MiseEnRebut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateFinAssurance = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateFinVisiteTechnique = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateVidange = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $alimentation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $allumage = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $assistanceFreinage = null;

    #[ORM\Column(nullable: true)]
    private ?float $capaciteCarburant = null;

    #[ORM\Column(length: 255, nullable: true)]
    private string $categorie = '';

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cession = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $chargeUtile = null;

    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank]
    private ?bool $climatiseur = null;

    #[ORM\Column(nullable: true)]
    private ?int $nbreCylindre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $numeroMoteur = null;

    #[ORM\Column(nullable: true)]
    private ?int $PMA = null;

    #[ORM\Column(nullable: true)]
    private ?float $puissance = null;

    #[ORM\Column(nullable: true)]
    private ?float $vitesse = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cylindree = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $directionAssistee = null;

    #[ORM\Column(nullable: true)]
    private ?int $dureeGuarantie = null;

    #[ORM\Column(nullable: true)]
    private ?int $dureVie = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $energie = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $freins = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $PVA = null;

    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank]
    private ?bool $radio = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $typeEnergie = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $typeTransmission = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $disponibilite = null;

    #[ORM\ManyToOne(inversedBy: 'vehicule')]
    private ?Financement $financement = null;

    #[ORM\ManyToOne(inversedBy: 'vehicule')]
    private ?TypeVehicule $typeVehicule = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $photoVehicule = null;

    #[Vich\UploadableField(mapping: 'vehicules', fileNameProperty:'photoVehicule')]
    #[Assert\Image()]
    private ?File $photoVehiculeFile = null;


    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deleteAt = null;

    #[ORM\ManyToOne(inversedBy: 'vehicules')]
    private ?Institution $institution = null;



    /**
     * @var Collection<int, Affecter>
     */
    #[ORM\OneToMany(targetEntity: Affecter::class, mappedBy: 'vehicule')]
    private Collection $affecters;

    /**
     * @var Collection<int, Assurance>
     */
    #[ORM\OneToMany(targetEntity: Assurance::class, mappedBy: 'vehiculeId')]
    private Collection $assurances;

    /**
     * @var Collection<int, Visite>
     */
    #[ORM\OneToMany(targetEntity: Visite::class, mappedBy: 'vehiculeId')]
    private Collection $visites;

    #[ORM\Column(nullable: true)]
    private ?int $nbreKmPourRenouvellerVidange = null;

    #[ORM\Column(nullable: true)]
    private ?int $kilometrageCourant = null;

    /**
     * @var Collection<int, Vidange>
     */
    #[ORM\OneToMany(targetEntity: Vidange::class, mappedBy: 'vehicule')]
    private Collection $vidanges;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $porteeVehicule = null;

    #[ORM\ManyToOne(inversedBy: 'vehicule')]
    private ?Parc $parc = null;

    public function __construct()
    {
        $this->affecters = new ArrayCollection();
        $this->assurances = new ArrayCollection();
        $this->visites = new ArrayCollection();
        $this->vidanges = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): static
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getNumeroChassis(): ?string
    {
        return $this->numeroChassis;
    }

    public function setNumeroChassis(string $numeroChassis): static
    {
        $this->numeroChassis = $numeroChassis;

        return $this;
    }

/*     public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): static
    {
        $this->marque = $marque;

        return $this;
    } */


    public function getMarque(): ?Marque
    {
        return $this->marque;
    }

    public function setMarque(?Marque $marque): static
    {
        $this->marque = $marque;

        return $this;
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(string $modele): static
    {
        $this->modele = $modele;

        return $this;
    }

    public function getNbrePlace(): ?int
    {
        return $this->nbrePlace;
    }

    public function setNbrePlace(int $nbrePlace): static
    {
        $this->nbrePlace = $nbrePlace;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(?string $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    public function getDateAcquisition(): ?\DateTimeInterface
    {
        return $this->dateAcquisition;
    }

    public function setDateAcquisition(?\DateTimeInterface $dateAcquisition): static
    {
        $this->dateAcquisition = $dateAcquisition;

        return $this;
    }

    public function getValeurAcquisition(): ?float
    {
        return $this->valeurAcquisition;
    }

    public function setValeurAcquisition(?float $valeurAcquisition): static
    {
        $this->valeurAcquisition = $valeurAcquisition;

        return $this;
    }

    public function getkilometrageInitial(): ?float
    {
        return $this->kilometrageInitial;
    }

    public function setkilometrageInitial(?float $kilometrageInitial): static
    {
        $this->kilometrageInitial = $kilometrageInitial;

        return $this;
    }

    public function getDateReception(): ?\DateTimeInterface
    {
        return $this->dateReception;
    }

    public function setDateReception(?\DateTimeInterface $dateReception): static
    {
        $this->dateReception = $dateReception;

        return $this;
    }

    public function getDateMiseEnCirculation(): ?\DateTimeInterface
    {
        return $this->dateMiseEnCirculation;
    }

    public function setDateMiseEnCirculation(?\DateTimeInterface $dateMiseEnCirculation): static
    {
        $this->dateMiseEnCirculation = $dateMiseEnCirculation;

        return $this;
    }

    public function isMiseEnRebut(): ?bool
    {
        return $this->MiseEnRebut;
    }

    public function setMiseEnRebut(?bool $MiseEnRebut): static
    {
        $this->MiseEnRebut = $MiseEnRebut;

        return $this;
    }

    public function getdateFinAssurance(): ?\DateTimeInterface
    {
        return $this->dateFinAssurance;
    }

    public function setdateFinAssurance(?\DateTimeInterface $dateFinAssurance): static
    {
        $this->dateFinAssurance = $dateFinAssurance;

        return $this;
    }

    public function getDateFinVisiteTechnique(): ?\DateTimeInterface
    {
        return $this->dateFinVisiteTechnique;
    }

    public function setDateFinVisiteTechnique(?\DateTimeInterface $dateFinVisiteTechnique): static
    {
        $this->dateFinVisiteTechnique = $dateFinVisiteTechnique;

        return $this;
    }

    public function getDateVidange(): ?\DateTimeInterface
    {
        return $this->dateVidange;
    }

    public function setDateVidange(?\DateTimeInterface $dateVidange): static
    {
        $this->dateVidange = $dateVidange;

        return $this;
    }

    public function getAlimentation(): ?string
    {
        return $this->alimentation;
    }

    public function setAlimentation(?string $alimentation): static
    {
        $this->alimentation = $alimentation;

        return $this;
    }

    public function getAllumage(): ?string
    {
        return $this->allumage;
    }

    public function setAllumage(?string $allumage): static
    {
        $this->allumage = $allumage;

        return $this;
    }

    public function getAssistanceFreinage(): ?string
    {
        return $this->assistanceFreinage;
    }

    public function setAssistanceFreinage(?string $assistanceFreinage): static
    {
        $this->assistanceFreinage = $assistanceFreinage;

        return $this;
    }

    public function getCapaciteCarburant(): ?float
    {
        return $this->capaciteCarburant;
    }

    public function setCapaciteCarburant(?float $capaciteCarburant): static
    {
        $this->capaciteCarburant = $capaciteCarburant;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(?string $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getCession(): ?string
    {
        return $this->cession;
    }

    public function setCession(?string $cession): static
    {
        $this->cession = $cession;

        return $this;
    }

    public function getChargeUtile(): ?string
    {
        return $this->chargeUtile;
    }

    public function setChargeUtile(?string $chargeUtile): static
    {
        $this->chargeUtile = $chargeUtile;

        return $this;
    }

    public function isClimatiseur(): ?bool
    {
        return $this->climatiseur;
    }

    public function setClimatiseur(?bool $climatiseur): static
    {
        $this->climatiseur = $climatiseur;

        return $this;
    }

    public function getNbreCylindre(): ?int
    {
        return $this->nbreCylindre;
    }

    public function setNbreCylindre(?int $nbreCylindre): static
    {
        $this->nbreCylindre = $nbreCylindre;

        return $this;
    }

    public function getNumeroMoteur(): ?string
    {
        return $this->numeroMoteur;
    }

    public function setNumeroMoteur(?string $numeroMoteur): static
    {
        $this->numeroMoteur = $numeroMoteur;

        return $this;
    }

    public function getPMA(): ?int
    {
        return $this->PMA;
    }

    public function setPMA(?int $PMA): static
    {
        $this->PMA = $PMA;

        return $this;
    }

    public function getPuissance(): ?float
    {
        return $this->puissance;
    }

    public function setPuissance(?float $puissance): static
    {
        $this->puissance = $puissance;

        return $this;
    }

    public function getVitesse(): ?float
    {
        return $this->vitesse;
    }

    public function setVitesse(?float $vitesse): static
    {
        $this->vitesse = $vitesse;

        return $this;
    }

    public function getCylindree(): ?string
    {
        return $this->cylindree;
    }

    public function setCylindree(?string $cylindree): static
    {
        $this->cylindree = $cylindree;

        return $this;
    }

    public function getDirectionAssistee(): ?string
    {
        return $this->directionAssistee;
    }

    public function setDirectionAssistee(?string $directionAssistee): static
    {
        $this->directionAssistee = $directionAssistee;

        return $this;
    }

    public function getDureeGuarantie(): ?int
    {
        return $this->dureeGuarantie;
    }

    public function setDureeGuarantie(?int $dureeGuarantie): static
    {
        $this->dureeGuarantie = $dureeGuarantie;

        return $this;
    }

    public function getDureVie(): ?int
    {
        return $this->dureVie;
    }

    public function setDureVie(?int $dureVie): static
    {
        $this->dureVie = $dureVie;

        return $this;
    }

    public function getEnergie(): ?string
    {
        return $this->energie;
    }

    public function setEnergie(?string $energie): static
    {
        $this->energie = $energie;

        return $this;
    }

    public function getFreins(): ?string
    {
        return $this->freins;
    }

    public function setFreins(?string $freins): static
    {
        $this->freins = $freins;

        return $this;
    }

    public function getPVA(): ?string
    {
        return $this->PVA;
    }

    public function setPVA(?string $PVA): static
    {
        $this->PVA = $PVA;

        return $this;
    }

    public function isRadio(): ?bool
    {
        return $this->radio;
    }

    public function setRadio(?bool $radio): static
    {
        $this->radio = $radio;

        return $this;
    }

    public function getTypeEnergie(): ?string
    {
        return $this->typeEnergie;
    }

    public function setTypeEnergie(?string $typeEnergie): static
    {
        $this->typeEnergie = $typeEnergie;

        return $this;
    }

    public function getTypeTransmission(): ?string
    {
        return $this->typeTransmission;
    }

    public function setTypeTransmission(?string $typeTransmission): static
    {
        $this->typeTransmission = $typeTransmission;

        return $this;
    }

    public function getDisponibilite(): ?string
    {
        return $this->disponibilite;
    }

    public function setDisponibilite(?string $disponibilite): static
    {
        $this->disponibilite = $disponibilite;

        return $this;
    }

    public function getFinancement(): ?Financement
    {
        return $this->financement;
    }

    public function setFinancement(?Financement $financement): static
    {
        $this->financement = $financement;

        return $this;
    }

    public function getTypeVehicule(): ?TypeVehicule
    {
        return $this->typeVehicule;
    }

    public function setTypeVehicule(?TypeVehicule $typeVehicule): static
    {
        $this->typeVehicule = $typeVehicule;

        return $this;
    }

    public function getphotoVehiculeFile(): ?string
    {
        return $this->photoVehiculeFile;
    }

    public function setphotoVehiculeFile(?string $photoVehiculeFile): static
    {
        $this->photoVehiculeFile = $photoVehiculeFile;

        return $this;
    }

    public function getPhotoVehicule(): ?string
    {
        return $this->photoVehicule;
    }

    public function setPhotoVehicule(?string $photoVehicule): static
    {
        $this->photoVehicule = $photoVehicule;

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

    public function getInstitution(): ?Institution
    {
        return $this->institution;
    }

    public function setInstitution(?Institution $institution): static
    {
        $this->institution = $institution;

        return $this;
    }


    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function validateDates(): void
    {
        if ($this->dateAcquisition && $this->dateReception) {
            if ($this->dateAcquisition > $this->dateReception) {
                throw new \InvalidArgumentException('La date d\'acquisition doit être antérieure ou égale à la date de réception.');
            }
        }

        if ($this->dateReception && $this->dateMiseEnCirculation) {
            if ($this->dateReception > $this->dateMiseEnCirculation) {
                throw new \InvalidArgumentException('La date de réception doit être antérieure ou égale à la date de mise en circulation.');
            }
        }
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
            $affecter->setVehicule($this);
        }

        return $this;
    }

    public function removeAffecter(Affecter $affecter): static
    {
        if ($this->affecters->removeElement($affecter)) {
            // set the owning side to null (unless already changed)
            if ($affecter->getVehicule() === $this) {
                $affecter->setVehicule(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Assurance>
     */
    public function getAssurances(): Collection
    {
        return $this->assurances;
    }

    public function addAssurance(Assurance $assurance): static
    {
        if (!$this->assurances->contains($assurance)) {
            $this->assurances->add($assurance);
            $assurance->setVehicule($this);
        }

        return $this;
    }

    public function removeAssurance(Assurance $assurance): static
    {
        if ($this->assurances->removeElement($assurance)) {
            // set the owning side to null (unless already changed)
            if ($assurance->getVehicule() === $this) {
                $assurance->setVehicule(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Visite>
     */
    public function getVisites(): Collection
    {
        return $this->visites;
    }

    public function addVisite(Visite $visite): static
    {
        if (!$this->visites->contains($visite)) {
            $this->visites->add($visite);
            $visite->setVehicule($this);
        }

        return $this;
    }

    public function removeVisite(Visite $visite): static
    {
        if ($this->visites->removeElement($visite)) {
            // set the owning side to null (unless already changed)
            if ($visite->getVehicule() === $this) {
                $visite->setVehicule(null);
            }
        }

        return $this;
    }

    public function getNbreKmPourRenouvellerVidange(): ?int
    {
        return $this->nbreKmPourRenouvellerVidange;
    }

    public function setNbreKmPourRenouvellerVidange(?int $nbreKmPourRenouvellerVidange): static
    {
        $this->nbreKmPourRenouvellerVidange = $nbreKmPourRenouvellerVidange;

        return $this;
    }

    public function getKilometrageCourant(): ?int
    {
        return $this->kilometrageCourant;
    }

    public function setKilometrageCourant(?int $kilometrageCourant): static
    {
        $this->kilometrageCourant = $kilometrageCourant;

        return $this;
    }

    /**
     * @return Collection<int, Vidange>
     */
    public function getVidanges(): Collection
    {
        return $this->vidanges;
    }

    public function addVidange(Vidange $vidange): static
    {
        if (!$this->vidanges->contains($vidange)) {
            $this->vidanges->add($vidange);
            $vidange->setVehicule($this);
        }

        return $this;
    }

    public function removeVidange(Vidange $vidange): static
    {
        if ($this->vidanges->removeElement($vidange)) {
            // set the owning side to null (unless already changed)
            if ($vidange->getVehicule() === $this) {
                $vidange->setVehicule(null);
            }
        }

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

    public function getParc(): ?Parc
    {
        return $this->parc;
    }

    public function setParc(?Parc $parc): static
    {
        $this->parc = $parc;

        return $this;
    }
}
