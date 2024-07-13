<?php

namespace App\Entity;

use App\Repository\InstitutionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: InstitutionRepository::class)]
#[Gedmo\SoftDeleteable(fieldName:"deleteAt", timeAware:false)]
#[UniqueEntity('libelleInstitution')]
class Institution
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private string $libelleInstitution = '';

    #[ORM\Column(length: 16, nullable: true)]
    #[Assert\Regex(
        pattern: '/^(\+229)?\s?(20|21|22|23|40|41|42|43|44|45|50|51|52|53|54|55|56|57|58|59|60|62|63|64|65|66|67|68|69|90|91|92|93|94|95|96|97|98|99)\s?\d{2}\s?\d{2}\s?\d{2}$/',
        match: true,
        message: 'Numéro de téléphone incorrecte',
    )]    
    private ?string $telephoneInstitution = null;

    /**
     * @var Collection<int, Utilisateur>
     */
    #[ORM\OneToMany(targetEntity: Utilisateur::class, mappedBy: 'institution')]
    private Collection $chefParc;

    #[ORM\ManyToOne(inversedBy: 'institution')]
    #[ORM\JoinColumn(name:"niveau_id", referencedColumnName:"id", onDelete:"RESTRICT")]
    private ?Niveau $niveau = null;

    /**
     * @var Collection<int, Chauffeur>
     */
    #[ORM\OneToMany(targetEntity: Chauffeur::class, mappedBy: 'institution')]
    private Collection $chauffeur;

    /**
     * @var Collection<int, Structure>
     */
    #[ORM\OneToMany(targetEntity: Structure::class, mappedBy: 'institution')]
    private Collection $structures;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deleteAt = null;

    /**
     * @var Collection<int, Vehicule>
     */
    #[ORM\OneToMany(targetEntity: Vehicule::class, mappedBy: 'institution')]
    private Collection $vehicules;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'institution')]
    private Collection $users;



    public function __construct()
    {
        $this->chefParc = new ArrayCollection();
        $this->chauffeur = new ArrayCollection();
        $this->structures = new ArrayCollection();
        $this->vehicules = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleInstitution(): ?string
    {
        return $this->libelleInstitution;
    }

    public function setLibelleInstitution(string $libelleInstitution): static
    {
        $this->libelleInstitution = $libelleInstitution;

        return $this;
    }

    public function getTelephoneInstitution(): ?string
    {
        return $this->telephoneInstitution;
    }

    public function setTelephoneInstitution(?string $telephoneInstitution): static
    {
        $this->telephoneInstitution = $telephoneInstitution;

        return $this;
    }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getChefParc(): Collection
    {
        return $this->chefParc;
    }

    public function addChefParc(Utilisateur $chefParc): static
    {
        if (!$this->chefParc->contains($chefParc)) {
            $this->chefParc->add($chefParc);
            $chefParc->setInstitution($this);
        }

        return $this;
    }

    public function removeChefParc(Utilisateur $chefParc): static
    {
        if ($this->chefParc->removeElement($chefParc)) {
            // set the owning side to null (unless already changed)
            if ($chefParc->getInstitution() === $this) {
                $chefParc->setInstitution(null);
            }
        }

        return $this;
    }

    public function getNiveau(): ?Niveau
    {
        return $this->niveau;
    }

    public function setNiveau(?Niveau $niveau): static
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * @return Collection<int, Chauffeur>
     */
    public function getChauffeur(): Collection
    {
        return $this->chauffeur;
    }

    public function addChauffeur(Chauffeur $chauffeur): static
    {
        if (!$this->chauffeur->contains($chauffeur)) {
            $this->chauffeur->add($chauffeur);
            $chauffeur->setInstitution($this);
        }

        return $this;
    }

    public function removeChauffeur(Chauffeur $chauffeur): static
    {
        if ($this->chauffeur->removeElement($chauffeur)) {
            // set the owning side to null (unless already changed)
            if ($chauffeur->getInstitution() === $this) {
                $chauffeur->setInstitution(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Structure>
     */
    public function getStructures(): Collection
    {
        return $this->structures;
    }

    public function addStructure(Structure $structure): static
    {
        if (!$this->structures->contains($structure)) {
            $this->structures->add($structure);
            $structure->setInstitution($this);
        }

        return $this;
    }

    public function removeStructure(Structure $structure): static
    {
        if ($this->structures->removeElement($structure)) {
            // set the owning side to null (unless already changed)
            if ($structure->getInstitution() === $this) {
                $structure->setInstitution(null);
            }
        }

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

    /**
     * @return Collection<int, Vehicule>
     */
    public function getVehicules(): Collection
    {
        return $this->vehicules;
    }

    public function addVehicule(Vehicule $vehicule): static
    {
        if (!$this->vehicules->contains($vehicule)) {
            $this->vehicules->add($vehicule);
            $vehicule->setInstitution($this);
        }

        return $this;
    }

    public function removeVehicule(Vehicule $vehicule): static
    {
        if ($this->vehicules->removeElement($vehicule)) {
            // set the owning side to null (unless already changed)
            if ($vehicule->getInstitution() === $this) {
                $vehicule->setInstitution(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setInstitution($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getInstitution() === $this) {
                $user->setInstitution(null);
            }
        }

        return $this;
    }
}
