<?php

namespace App\Entity;

use App\Repository\TestRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TestRepository::class)]
class Test
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $champ1 = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChamp1(): ?string
    {
        return $this->champ1;
    }

    public function setChamp1(string $champ1): static
    {
        $this->champ1 = $champ1;

        return $this;
    }
}
