<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\VehiculeRepository;
use Symfony\Component\HttpFoundation\File\File;
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
    private ?int $id = null;

    #[ORM\Column(length: 255)]
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
    private ?float $Kilometrage = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateReception = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateMiseEnCirculation = null;

    #[ORM\Column(nullable: true)]
    private ?bool $MiseEnRebut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateDebutVisiteTechnique = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateFinVisiteTechnique = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateEntretien = null;

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

    public function getKilometrage(): ?float
    {
        return $this->Kilometrage;
    }

    public function setKilometrage(?float $Kilometrage): static
    {
        $this->Kilometrage = $Kilometrage;

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

    public function getDateDebutVisiteTechnique(): ?\DateTimeInterface
    {
        return $this->dateDebutVisiteTechnique;
    }

    public function setDateDebutVisiteTechnique(?\DateTimeInterface $dateDebutVisiteTechnique): static
    {
        $this->dateDebutVisiteTechnique = $dateDebutVisiteTechnique;

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

    public function getDateEntretien(): ?\DateTimeInterface
    {
        return $this->dateEntretien;
    }

    public function setDateEntretien(?\DateTimeInterface $dateEntretien): static
    {
        $this->dateEntretien = $dateEntretien;

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
}
