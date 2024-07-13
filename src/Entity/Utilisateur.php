<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UtilisateurRepository;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomUtilisateur = null;

    #[ORM\Column(length: 255)]
    private ?string $prenomUtilisateur = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateNaissance = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Email]
    private ?string $email = null;


    #[ORM\Column(length: 16, nullable: true)]
    #[Assert\Regex(
        pattern: '/^(\+229)?\s?(20|21|22|23|40|41|42|43|44|45|50|51|52|53|54|55|56|57|58|59|60|62|63|64|65|66|67|68|69|90|91|92|93|94|95|96|97|98|99)\s?\d{2}\s?\d{2}\s?\d{2}$/',
        match: true,
        message: 'Numéro de téléphone incorrecte',
    )]  
    private ?string $telephoneUtilisateur = null;

    #[ORM\Column(length: 255)]
    private ?string $login = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    public ?string $confirm_password = null;

   

    #[ORM\ManyToOne(inversedBy: 'responsable')]
    private ?Structure $structure = null;

    #[ORM\ManyToOne(inversedBy: 'chefParc')]
    private ?Institution $institution = null;

    #[ORM\Column(length: 255)]
    private ?string $matriculeUtilisateur = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deleteAt = null;

    #[ORM\Column(length: 255)]
    private ?string $etatUtilisateur = null;

    /**
     * @var Collection<int, Demande>
     */
    #[ORM\OneToMany(targetEntity: Demande::class, mappedBy: 'demander')]
    private Collection $demandes;

    /**
     * @var Collection<int, Demande>
     */
    #[ORM\OneToMany(targetEntity: Demande::class, mappedBy: 'validateurStructure')]
    private Collection $demandesValidateurs;

    /**
     * @var Collection<int, Demande>
     */
    #[ORM\OneToMany(targetEntity: Demande::class, mappedBy: 'traitePar')]
    private Collection $demandesTraiteur;

    public function __construct()
    {
        $this->demandes = new ArrayCollection();
        $this->demandesValidateurs = new ArrayCollection();
        $this->demandesTraiteur = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomUtilisateur(): ?string
    {
        return $this->nomUtilisateur;
    }

    public function setNomUtilisateur(string $nomUtilisateur): static
    {
        $this->nomUtilisateur = $nomUtilisateur;

        return $this;
    }

    public function getPrenomUtilisateur(): ?string
    {
        return $this->prenomUtilisateur;
    }

    public function setPrenomUtilisateur(string $prenomUtilisateur): static
    {
        $this->prenomUtilisateur = $prenomUtilisateur;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(?\DateTimeInterface $dateNaissance): static
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephoneUtilisateur(): ?string
    {
        return $this->telephoneUtilisateur;
    }

    public function setTelephoneUtilisateur(?string $telephoneUtilisateur): static
    {
        $this->telephoneUtilisateur = $telephoneUtilisateur;

        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): static
    {
        $this->login = $login;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

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

    public function getMatriculeUtilisateur(): ?string
    {
        return $this->matriculeUtilisateur;
    }

    public function setMatriculeUtilisateur(string $matriculeUtilisateur): static
    {
        $this->matriculeUtilisateur = $matriculeUtilisateur;

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

    public function getEtatUtilisateur(): ?string
    {
        return $this->etatUtilisateur;
    }

    public function setEtatUtilisateur(string $etatUtilisateur): static
    {
        $this->etatUtilisateur = $etatUtilisateur;

        return $this;
    }

    /**
     * @return Collection<int, Demande>
     */
    public function getDemandes(): Collection
    {
        return $this->demandes;
    }

/*     public function addDemande(Demande $demande): static
    {
        if (!$this->demandes->contains($demande)) {
            $this->demandes->add($demande);
            $demande->setDemander($this);
        }

        return $this;
    } */

    public function removeDemande(Demande $demande): static
    {
        if ($this->demandes->removeElement($demande)) {
            // set the owning side to null (unless already changed)
            if ($demande->getDemander() === $this) {
                $demande->setDemander(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Demande>
     */
    public function getDemandesValidateurs(): Collection
    {
        return $this->demandesValidateurs;
    }

/*     public function addDemandesValidateur(Demande $demandesValidateur): static
    {
        if (!$this->demandesValidateurs->contains($demandesValidateur)) {
            $this->demandesValidateurs->add($demandesValidateur);
            $demandesValidateur->setValidateurStructure($this);
        }

        return $this;
    } */

    public function removeDemandesValidateur(Demande $demandesValidateur): static
    {
        if ($this->demandesValidateurs->removeElement($demandesValidateur)) {
            // set the owning side to null (unless already changed)
            if ($demandesValidateur->getValidateurStructure() === $this) {
                $demandesValidateur->setValidateurStructure(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Demande>
     */
    public function getDemandesTraiteur(): Collection
    {
        return $this->demandesTraiteur;
    }

/*     public function addDemandesTraiteur(Demande $demandesTraiteur): static
    {
        if (!$this->demandesTraiteur->contains($demandesTraiteur)) {
            $this->demandesTraiteur->add($demandesTraiteur);
            $demandesTraiteur->setTraitePar($this);
        }

        return $this;
    } */

    public function removeDemandesTraiteur(Demande $demandesTraiteur): static
    {
        if ($this->demandesTraiteur->removeElement($demandesTraiteur)) {
            // set the owning side to null (unless already changed)
            if ($demandesTraiteur->getTraitePar() === $this) {
                $demandesTraiteur->setTraitePar(null);
            }
        }

        return $this;
    }
}
