<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use App\Repository\ChauffeurRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


#[Gedmo\SoftDeleteable(fieldName:"deleteAt", timeAware:false)]
#[UniqueEntity(fields: ['matriculeChauffeur'])]
#[UniqueEntity(fields: ['numPermis'])]
#[ORM\Entity(repositoryClass: ChauffeurRepository::class)]
class Chauffeur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('chauffeur_list')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups('chauffeur_list')]
    private string $nomChauffeur = '';

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups('chauffeur_list')]
    private string $prenomChauffeur = '';


    #[ORM\Column(length: 16, nullable: true)]
    #[Assert\NotBlank]
    #[Assert\Regex(
        pattern: '/^(\+229)?\s?(20|21|22|23|40|41|42|43|44|45|50|51|52|53|54|55|56|57|58|59|60|62|63|64|65|66|67|68|69|90|91|92|93|94|95|96|97|98|99)\s?\d{2}\s?\d{2}\s?\d{2}$/',
        match: true,
        message: 'Numéro de téléphone incorrecte',
    )]
    private ?string $telephoneChauffeur = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private string $numPermis = '';

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $etatChauffeur = null;

    #[ORM\ManyToOne(inversedBy: 'chauffeur')]
    private ?Institution $institution = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deleteAt = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private string $matriculeChauffeur = '';


    #[ORM\Column(length: 255, nullable: true)]
    private ?string $disponibilite = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photoChauffeur = null;

    /**
     * @var Collection<int, Affecter>
     */
    #[ORM\OneToMany(targetEntity: Affecter::class, mappedBy: 'chauffeur')]
    private Collection $affecters;

    #[ORM\ManyToOne(inversedBy: 'chauffeurs')]
    private ?Parc $parc = null;

    public function __construct()
    {
        $this->affecters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomChauffeur(): ?string
    {
        return $this->nomChauffeur;
    }

    public function setNomChauffeur(string $nomChauffeur): static
    {
        $this->nomChauffeur = $nomChauffeur;

        return $this;
    }

    public function getPrenomChauffeur(): ?string
    {
        return $this->prenomChauffeur;
    }

    public function setPrenomChauffeur(string $prenomChauffeur): static
    {
        $this->prenomChauffeur = $prenomChauffeur;

        return $this;
    }

    public function getTelephoneChauffeur(): ?string
    {
        return $this->telephoneChauffeur;
    }

    public function setTelephoneChauffeur(?string $telephoneChauffeur): static
    {
        $this->telephoneChauffeur = $telephoneChauffeur;

        return $this;
    }

    public function getNumPermis(): ?string
    {
        return $this->numPermis;
    }

    public function setNumPermis(string $numPermis): static
    {
        $this->numPermis = $numPermis;

        return $this;
    }

    public function getEtatChauffeur(): ?string
    {
        return $this->etatChauffeur;
    }

    public function setEtatChauffeur(?string $etatChauffeur): static
    {
        $this->etatChauffeur = $etatChauffeur;

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

    public function getDeleteAt(): ?\DateTimeImmutable
    {
        return $this->deleteAt;
    }

    public function setDeleteAt(?\DateTimeImmutable $deleteAt): static
    {
        $this->deleteAt = $deleteAt;

        return $this;
    }

    public function getMatriculeChauffeur(): ?string
    {
        return $this->matriculeChauffeur;
    }

    public function setMatriculeChauffeur(string $matriculeChauffeur): static
    {
        $this->matriculeChauffeur = $matriculeChauffeur;

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

    public function getPhotoChauffeur(): ?string
    {
        return $this->photoChauffeur;
    }

    public function setPhotoChauffeur(?string $photoChauffeur): static
    {
        $this->photoChauffeur = $photoChauffeur;

        return $this;
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
            $affecter->setChauffeur($this);
        }

        return $this;
    }

    public function removeAffecter(Affecter $affecter): static
    {
        if ($this->affecters->removeElement($affecter)) {
            // set the owning side to null (unless already changed)
            if ($affecter->getChauffeur() === $this) {
                $affecter->setChauffeur(null);
            }
        }

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
