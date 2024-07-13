<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\StructureRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: StructureRepository::class)]
#[Gedmo\SoftDeleteable(fieldName:"deleteAt", timeAware:false)]
#[UniqueEntity(fields: ['libelleStructure', 'institution'])]
class Structure
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private string $libelleStructure = '';

    #[ORM\Column(length: 16, nullable: true)]
    #[Assert\Regex(
        pattern: '/^(\+229)?\s?(20|21|22|23|40|41|42|43|44|45|50|51|52|53|54|55|56|57|58|59|60|62|63|64|65|66|67|68|69|90|91|92|93|94|95|96|97|98|99)\s?\d{2}\s?\d{2}\s?\d{2}$/',
        match: true,
        message: 'Numéro de téléphone incorrecte',
    )]  
    private ?string $telephoneStructure = null;

    /**
     * @var Collection<int, Utilisateur>
     */
    #[ORM\OneToMany(targetEntity: Utilisateur::class, mappedBy: 'structure')]
    private Collection $responsable;

    #[ORM\ManyToOne(inversedBy: 'structures')]
    private ?TypeStructure $typeStructure = null;

    #[ORM\ManyToOne(inversedBy: 'structures')]
    #[Assert\NotBlank]
    private ?Institution $institution = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $libelleLongStructure = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deleteAt = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'structure')]
    private Collection $users;

    public function __construct()
    {
        $this->responsable = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleStructure(): ?string
    {
        return $this->libelleStructure;
    }

    public function setLibelleStructure(string $libelleStructure): static
    {
        $this->libelleStructure = $libelleStructure;

        return $this;
    }

    public function getTelephoneStructure(): ?string
    {
        return $this->telephoneStructure;
    }

    public function setTelephoneStructure(?string $telephoneStructure): static
    {
        $this->telephoneStructure = $telephoneStructure;

        return $this;
    }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getResponsable(): Collection
    {
        return $this->responsable;
    }

    public function addResponsable(Utilisateur $responsable): static
    {
        if (!$this->responsable->contains($responsable)) {
            $this->responsable->add($responsable);
            $responsable->setStructure($this);
        }

        return $this;
    }

    public function removeResponsable(Utilisateur $responsable): static
    {
        if ($this->responsable->removeElement($responsable)) {
            // set the owning side to null (unless already changed)
            if ($responsable->getStructure() === $this) {
                $responsable->setStructure(null);
            }
        }

        return $this;
    }

    public function getTypeStructure(): ?TypeStructure
    {
        return $this->typeStructure;
    }

    public function setTypeStructure(?TypeStructure $typeStructure): static
    {
        $this->typeStructure = $typeStructure;

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

    public function getLibelleLongStructure(): ?string
    {
        return $this->libelleLongStructure;
    }

    public function setLibelleLongStructure(string $libelleLongStructure): static
    {
        $this->libelleLongStructure = $libelleLongStructure;

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
            $user->setStructure($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getStructure() === $this) {
                $user->setStructure(null);
            }
        }

        return $this;
    }
}

