<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TypeStructureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


#[ORM\Entity(repositoryClass: TypeStructureRepository::class)]
#[Gedmo\SoftDeleteable(fieldName:"deleteAt", timeAware:false)]
#[UniqueEntity('libelleTypeStructure')]
class TypeStructure
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private string $libelleTypeStructure = '';

    /**
     * @var Collection<int, Structure>
     */
    #[ORM\OneToMany(targetEntity: Structure::class, mappedBy: 'typeStructure')]
    private Collection $structures;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deleteAt = null;

    public function __construct()
    {
        $this->structures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleTypeStructure(): ?string
    {
        return $this->libelleTypeStructure;
    }

    public function setLibelleTypeStructure(string $libelleTypeStructure): static
    {
        $this->libelleTypeStructure = $libelleTypeStructure;

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
            $structure->setTypeStructure($this);
        }

        return $this;
    }

    public function removeStructure(Structure $structure): static
    {
        if ($this->structures->removeElement($structure)) {
            // set the owning side to null (unless already changed)
            if ($structure->getTypeStructure() === $this) {
                $structure->setTypeStructure(null);
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
