<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use App\Repository\DepartementRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: DepartementRepository::class)]
#[Gedmo\SoftDeleteable(fieldName:"deleteAt", timeAware:false)]
#[UniqueEntity('libelleDepartement')]
class Departement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    private string $libelleDepartement = '';

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    private string $region = '';

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $deleteAt = null;

    #[ORM\OneToMany(targetEntity: Commune::class, mappedBy: 'departement')]
    private Collection $communes;

    public function __construct()
    {
        $this->communes = new ArrayCollection();
    }

    // Getters et setters...

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleDepartement(): ?string
    {
        return $this->libelleDepartement;
    }

    public function setLibelleDepartement(string $libelleDepartement): self
    {
        $this->libelleDepartement = $libelleDepartement;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getDeleteAt(): ?\DateTimeInterface
    {
        return $this->deleteAt;
    }

    public function setDeleteAt(?\DateTimeInterface $deleteAt): self
    {
        $this->deleteAt = $deleteAt;

        return $this;
    }

    public function getCommunes(): Collection
    {
        return $this->communes;
    }

    public function addCommune(Commune $commune): self
    {
        if (!$this->communes->contains($commune)) {
            $this->communes[] = $commune;
            $commune->setDepartement($this);
        }

        return $this;
    }

    public function removeCommune(Commune $commune): self
    {
        if ($this->communes->removeElement($commune)) {
            // set the owning side to null (unless already changed)
            if ($commune->getDepartement() === $this) {
                $commune->setDepartement(null);
            }
        }

        return $this;
    }
}
