<?php

namespace App\Entity;

use App\Repository\ParcRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ParcRepository::class)]
#[Gedmo\SoftDeleteable(fieldName:"deleteAt", timeAware:false)]
#[UniqueEntity('nomParc')]
class Parc
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private string $nomParc = '';

    #[ORM\ManyToOne(inversedBy: 'parcs')]
    private ?Institution $institution = null;

    /**
     * @var Collection<int, Structure>
     */
    #[ORM\OneToMany(targetEntity: Structure::class, mappedBy: 'parc')]
    private Collection $structure;

    #[ORM\ManyToOne(inversedBy: 'parcs')]
    private ?User $chefParc = null;

    /**
     * @var Collection<int, Vehicule>
     */
    #[ORM\OneToMany(targetEntity: Vehicule::class, mappedBy: 'parc')]
    private Collection $vehicule;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deleteAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank]
    #[Assert\Regex(
        pattern: '/^(\+229)?\s?(20|21|22|23|40|41|42|43|44|45|50|51|52|53|54|55|56|57|58|59|60|62|63|64|65|66|67|68|69|90|91|92|93|94|95|96|97|98|99)\s?\d{2}\s?\d{2}\s?\d{2}$/',
        match: true,
        message: 'Numéro de téléphone incorrecte',
    )]  
    private ?string $telephoneParc = null;

    #[ORM\Column(length: 255, nullable: true)]
    private string $emailParc = '';

    #[ORM\ManyToOne(inversedBy: 'ParcsValidateurs')]
    private ?User $validateurParc = null;



    public function __construct()
    {
        $this->structure = new ArrayCollection();
        $this->vehicule = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomParc(): ?string
    {
        return $this->nomParc;
    }

    public function setNomParc(string $nomParc): static
    {
        $this->nomParc = $nomParc;

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

    /**
     * @return Collection<int, Structure>
     */
    public function getStructure(): Collection
    {
        return $this->structure;
    }

    public function addStructure(Structure $structure): static
    {
        if (!$this->structure->contains($structure)) {
            $this->structure->add($structure);
            $structure->setParc($this);
        }

        return $this;
    }

    public function removeStructure(Structure $structure): static
    {
        if ($this->structure->removeElement($structure)) {
            // set the owning side to null (unless already changed)
            if ($structure->getParc() === $this) {
                $structure->setParc(null);
            }
        }

        return $this;
    }

    public function getChefParc(): ?User
    {
        return $this->chefParc;
    }

    public function setChefParc(?User $chefParc): static
    {
        $this->chefParc = $chefParc;

        return $this;
    }

    /**
     * @return Collection<int, Vehicule>
     */
    public function getVehicule(): Collection
    {
        return $this->vehicule;
    }

    public function addVehicule(Vehicule $vehicule): static
    {
        if (!$this->vehicule->contains($vehicule)) {
            $this->vehicule->add($vehicule);
            $vehicule->setParc($this);
        }

        return $this;
    }

    public function removeVehicule(Vehicule $vehicule): static
    {
        if ($this->vehicule->removeElement($vehicule)) {
            // set the owning side to null (unless already changed)
            if ($vehicule->getParc() === $this) {
                $vehicule->setParc(null);
            }
        }

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

    public function getTelephoneParc(): ?string
    {
        return $this->telephoneParc;
    }

    public function setTelephoneParc(?string $telephoneParc): static
    {
        $this->telephoneParc = $telephoneParc;

        return $this;
    }

    public function getEmailParc(): ?string
    {
        return $this->emailParc;
    }

    public function setEmailParc(?string $emailParc): static
    {
        $this->emailParc = $emailParc;

        return $this;
    }

    public function getValidateurParc(): ?User
    {
        return $this->validateurParc;
    }

    public function setValidateurParc(?User $validateurParc): static
    {
        $this->validateurParc = $validateurParc;

        return $this;
    }
}
