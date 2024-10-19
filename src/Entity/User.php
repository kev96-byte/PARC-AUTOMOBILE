<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_USERNAME', fields: ['username'])]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_MATRICULE', fields: ['matricule'])]
#[UniqueEntity(fields: ['username'], message: 'Ce nom d\'utilisateur existe dejà')]
#[UniqueEntity(fields: ['email'], message: 'Cette adresse mail existe dejà')]
#[UniqueEntity(fields: ['matricule'], message: 'Ce matricule existe dejà')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    private ?string $username = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    #[Assert\NotBlank]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\NotBlank]
    private string $password = '';

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private string $lastName = '';

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private string $firstName = '';

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank]
    private string $email = '';

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deleteAt = null;

    #[ORM\Column]
    private bool $isVerified = false;

    #[ORM\Column(length: 255)]
    private ?string $statutCompte = null;

    #[ORM\Column(length: 255)]
    private ?string $matricule = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank]
    #[Assert\Regex(
        pattern: '/^(\+229)?[0-9]{8}$/',
        message: 'Numéro de téléphone incorrecte',
        match: true,
    )]
    private ?string $telephone = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Institution $institution = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Structure $structure = null;

 
    
     /**
     * @var Collection<int, Demande>
     */
    #[ORM\OneToMany(targetEntity: Demande::class, mappedBy: 'demander')]
    private Collection $demandes;

    /**
     * @var Collection<int, Demande>
     */
    #[ORM\OneToMany(targetEntity: Demande::class, mappedBy: 'responsableStructure')]
    private Collection $structuresResponsables;


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

    /**
     * @var Collection<int, Demande>
     */
    #[ORM\OneToMany(targetEntity: Demande::class, mappedBy: 'finaliserPar')]
    private Collection $demandesfinaliser;

    /**
     * @var Collection<int, Demande>
     */
    #[ORM\OneToMany(targetEntity: Demande::class, mappedBy: 'finaliserPar')]
    private Collection $demandesfinaliserpar;

    /**
     * @var Collection<int, Parc>
     */
    #[ORM\OneToMany(targetEntity: Parc::class, mappedBy: 'chefParc')]
    private Collection $parcs;

    public function __construct()
    {
        $this->demandes = new ArrayCollection();
        $this->structuresResponsables = new ArrayCollection();
        $this->demandesValidateurs = new ArrayCollection();
        $this->demandesTraiteur = new ArrayCollection();
        $this->demandesfinaliser = new ArrayCollection();
        $this->demandesfinaliserpar = new ArrayCollection();
        $this->parcs = new ArrayCollection();
        $this->userWhoCancelledRequest = new ArrayCollection();
        $this->userWhoCancellationRequest = new ArrayCollection();
        $this->whoValideDemandes = new ArrayCollection();
        $this->ParcsValidateurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

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

    public function getDeleteAt(): ?\DateTimeImmutable
    {
        return $this->deleteAt;
    }

    public function setDeleteAt(?\DateTimeImmutable $deleteAt): static
    {
        $this->deleteAt = $deleteAt;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getStatutCompte(): ?string
    {
        return $this->statutCompte;
    }

    public function setStatutCompte(string $statutCompte): static
    {
        $this->statutCompte = $statutCompte;

        return $this;
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

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): static
    {
        $this->telephone = $telephone;

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

    public function getStructure(): ?Structure
    {
        return $this->structure;
    }

    public function setStructure(?Structure $structure): static
    {
        $this->structure = $structure;

        return $this;
    }

     /**
     * @return Collection<int, Demande>
     */
    public function getDemandes(): Collection
    {
        return $this->demandes;
    }

    public function addDemande(Demande $demande): static
    {
        if (!$this->demandes->contains($demande)) {
            $this->demandes->add($demande);
            $demande->setDemander($this);
        }

        return $this;
    }

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


    public function addDemandesValidateur(Demande $demandesValidateur): static
    {
        if (!$this->demandesValidateurs->contains($demandesValidateur)) {
            $this->demandesValidateurs->add($demandesValidateur);
            $demandesValidateur->setValidateurStructure($this);
        }

        return $this;
    }


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

    public function addDemandesTraiteur(Demande $demandesTraiteur): static
    {
        if (!$this->demandesTraiteur->contains($demandesTraiteur)) {
            $this->demandesTraiteur->add($demandesTraiteur);
            $demandesTraiteur->setTraiterPar($this);
        }

        return $this;
    }

    public function removeDemandesTraiteur(Demande $demandesTraiteur): static
    {
        if ($this->demandesTraiteur->removeElement($demandesTraiteur)) {
            // set the owning side to null (unless already changed)
            if ($demandesTraiteur->getTraiterPar() === $this) {
                $demandesTraiteur->setTraiterPar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Demande>
     */
    public function getDemandesfinaliser(): Collection
    {
        return $this->demandesfinaliser;
    }

    public function addDemandesfinaliser(Demande $demandesfinaliser): static
    {
        if (!$this->demandesfinaliser->contains($demandesfinaliser)) {
            $this->demandesfinaliser->add($demandesfinaliser);
            $demandesfinaliser->setFinaliserPar($this);
        }

        return $this;
    }

    public function removeDemandesfinaliser(Demande $demandesfinaliser): static
    {
        if ($this->demandesfinaliser->removeElement($demandesfinaliser)) {
            // set the owning side to null (unless already changed)
            if ($demandesfinaliser->getFinaliserPar() === $this) {
                $demandesfinaliser->setFinaliserPar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Demande>
     */
    public function getDemandesfinaliserpar(): Collection
    {
        return $this->demandesfinaliserpar;
    }

    public function addDemandesfinaliserpar(Demande $demandesfinaliserpar): static
    {
        if (!$this->demandesfinaliserpar->contains($demandesfinaliserpar)) {
            $this->demandesfinaliserpar->add($demandesfinaliserpar);
            $demandesfinaliserpar->setFinaliserPar($this);
        }

        return $this;
    }

    public function removeDemandesfinaliserpar(Demande $demandesfinaliserpar): static
    {
        if ($this->demandesfinaliserpar->removeElement($demandesfinaliserpar)) {
            // set the owning side to null (unless already changed)
            if ($demandesfinaliserpar->getFinaliserPar() === $this) {
                $demandesfinaliserpar->setFinaliserPar(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->username; // Assurez-vous que la propriété 'username' existe
    }

    /**
     * @return Collection<int, Parc>
     */
    public function getParcs(): Collection
    {
        return $this->parcs;
    }

    public function addParc(Parc $parc): static
    {
        if (!$this->parcs->contains($parc)) {
            $this->parcs->add($parc);
            $parc->setChefParc($this);
        }

        return $this;
    }

    public function removeParc(Parc $parc): static
    {
        if ($this->parcs->removeElement($parc)) {
            // set the owning side to null (unless already changed)
            if ($parc->getChefParc() === $this) {
                $parc->setChefParc(null);
            }
        }

        return $this;
    }

    #[ORM\Column(type: 'boolean')]
    private bool $isFirstLogin = true;

    /**
     * @var Collection<int, Demande>
     */
    #[ORM\OneToMany(targetEntity: Demande::class, mappedBy: 'cancelledBy')]
    private Collection $userWhoCancelledRequest;

    /**
     * @var Collection<int, Demande>
     */
    #[ORM\OneToMany(targetEntity: Demande::class, mappedBy: 'cancellationRequestBy')]
    private Collection $userWhoCancellationRequest;

    /**
     * @var Collection<int, Demande>
     */
    #[ORM\OneToMany(targetEntity: Demande::class, mappedBy: 'validatedBy')]
    private Collection $whoValideDemandes;

    /**
     * @var Collection<int, Parc>
     */
    #[ORM\OneToMany(targetEntity: Parc::class, mappedBy: 'validateurParc')]
    private Collection $ParcsValidateurs;

    public function isFirstLogin(): bool
    {
        return $this->isFirstLogin;
    }

    public function setIsFirstLogin(bool $isFirstLogin): self
    {
        $this->isFirstLogin = $isFirstLogin;
        return $this;
    }

    /**
     * @return Collection<int, Demande>
     */
    public function getUserWhoCancelledRequest(): Collection
    {
        return $this->userWhoCancelledRequest;
    }

    public function addUserWhoCancelledRequest(Demande $userWhoCancelledRequest): static
    {
        if (!$this->userWhoCancelledRequest->contains($userWhoCancelledRequest)) {
            $this->userWhoCancelledRequest->add($userWhoCancelledRequest);
            $userWhoCancelledRequest->setCancelledBy($this);
        }

        return $this;
    }

    public function removeUserWhoCancelledRequest(Demande $userWhoCancelledRequest): static
    {
        if ($this->userWhoCancelledRequest->removeElement($userWhoCancelledRequest)) {
            // set the owning side to null (unless already changed)
            if ($userWhoCancelledRequest->getCancelledBy() === $this) {
                $userWhoCancelledRequest->setCancelledBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Demande>
     */
    public function getUserWhoCancellationRequest(): Collection
    {
        return $this->userWhoCancellationRequest;
    }

    public function addUserWhoCancellationRequest(Demande $userWhoCancellationRequest): static
    {
        if (!$this->userWhoCancellationRequest->contains($userWhoCancellationRequest)) {
            $this->userWhoCancellationRequest->add($userWhoCancellationRequest);
            $userWhoCancellationRequest->setCancellationRequestBy($this);
        }

        return $this;
    }

    public function removeUserWhoCancellationRequest(Demande $userWhoCancellationRequest): static
    {
        if ($this->userWhoCancellationRequest->removeElement($userWhoCancellationRequest)) {
            // set the owning side to null (unless already changed)
            if ($userWhoCancellationRequest->getCancellationRequestBy() === $this) {
                $userWhoCancellationRequest->setCancellationRequestBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Demande>
     */
    public function getWhoValideDemandes(): Collection
    {
        return $this->whoValideDemandes;
    }

    public function addWhoValideDemande(Demande $whoValideDemande): static
    {
        if (!$this->whoValideDemandes->contains($whoValideDemande)) {
            $this->whoValideDemandes->add($whoValideDemande);
            $whoValideDemande->setValidatedBy($this);
        }

        return $this;
    }

    public function removeWhoValideDemande(Demande $whoValideDemande): static
    {
        if ($this->whoValideDemandes->removeElement($whoValideDemande)) {
            // set the owning side to null (unless already changed)
            if ($whoValideDemande->getValidatedBy() === $this) {
                $whoValideDemande->setValidatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Parc>
     */
    public function getParcsValidateurs(): Collection
    {
        return $this->ParcsValidateurs;
    }

    public function addParcsValidateur(Parc $parcsValidateur): static
    {
        if (!$this->ParcsValidateurs->contains($parcsValidateur)) {
            $this->ParcsValidateurs->add($parcsValidateur);
            $parcsValidateur->setValidateurParc($this);
        }

        return $this;
    }

    public function removeParcsValidateur(Parc $parcsValidateur): static
    {
        if ($this->ParcsValidateurs->removeElement($parcsValidateur)) {
            // set the owning side to null (unless already changed)
            if ($parcsValidateur->getValidateurParc() === $this) {
                $parcsValidateur->setValidateurParc(null);
            }
        }

        return $this;
    }


            /**
     * @return Collection<int, Structure>
     */
    public function getStructuresResponsables(): Collection
    {
        return $this->structuresResponsables;
    }


    public function addStructuresResponsable(Structure $structuresResponsable): static
    {
        if (!$this->structuresResponsables->contains($structuresResponsable)) {
            $this->structuresResponsables->add($structuresResponsable);
            $structuresResponsable->setResponsableStructure($this);
        }

        return $this;
    }


    public function removeStructuresResponsable(Structure $structuresResponsable): static
    {
        if ($this->structuresResponsables->removeElement($structuresResponsable)) {
            // set the owning side to null (unless already changed)
            if ($structuresResponsable->getResponsableStructure() === $this) {
                $structuresResponsable->setResponsableStructure(null);
            }
        }

        return $this;
    }

}
