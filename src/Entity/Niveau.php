<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\NiveauRepository;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: NiveauRepository::class)]
#[Gedmo\SoftDeleteable(fieldName:"deleteAt", timeAware:false)]
#[UniqueEntity('libelleNiveau')]
class Niveau
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private string $libelleNiveau = '';

    /**
     * @var Collection<int, Institution>
     */
    #[ORM\OneToMany(targetEntity: Institution::class, mappedBy: 'niveau')]
    private Collection $institution;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deleteAt = null;

    public function __construct()
    {
        $this->institution = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleNiveau(): string
    {
        return $this->libelleNiveau;
    }

    public function setLibelleNiveau(string $libelleNiveau): static
    {
        $this->libelleNiveau = $libelleNiveau;

        return $this;
    }

    /**
     * @return Collection<int, Institution>
     */
    public function getInstitution(): Collection
    {
        return $this->institution;
    }

    public function addInstitution(Institution $institution): static
    {
        if (!$this->institution->contains($institution)) {
            $this->institution->add($institution);
            $institution->setNiveau($this);
        }

        return $this;
    }

    public function removeInstitution(Institution $institution): static
    {
        if ($this->institution->removeElement($institution)) {
            // set the owning side to null (unless already changed)
            if ($institution->getNiveau() === $this) {
                $institution->setNiveau(null);
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

}
