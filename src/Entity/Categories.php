<?php

namespace App\Entity;

use App\Repository\CategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoriesRepository::class)]
class Categories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'categorie', targetEntity: Music::class)]
    private Collection $musique;

    public function __construct()
    {
        $this->musique = new ArrayCollection();
    }
    public function __toString(){
        return $this->getName(); // Remplacer champ par une propriété "string" de l'entité
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Music>
     */
    public function getMusique(): Collection
    {
        return $this->musique;
    }

    public function addMusique(Music $musique): self
    {
        if (!$this->musique->contains($musique)) {
            $this->musique->add($musique);
            $musique->setCategorie($this);
        }

        return $this;
    }

    public function removeMusique(Music $musique): self
    {
        if ($this->musique->removeElement($musique)) {
            // set the owning side to null (unless already changed)
            if ($musique->getCategorie() === $this) {
                $musique->setCategorie(null);
            }
        }

        return $this;
    }

}