<?php

namespace App\Entity;

use App\Repository\CoursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoursRepository::class)]
class Cours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nomCours;

    #[ORM\Column(type: 'string', length: 255)]
    private $heureCours;

    #[ORM\ManyToMany(targetEntity: Classe::class, inversedBy: 'cours')]
    private $classe;

    #[ORM\ManyToMany(targetEntity: Etudiant::class, inversedBy: 'cours')]
    private $prof;

    public function __construct()
    {
        $this->classe = new ArrayCollection();
        $this->prof = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCours(): ?string
    {
        return $this->nomCours;
    }

    public function setNomCours(string $nomCours): self
    {
        $this->nomCours = $nomCours;

        return $this;
    }

    public function getHeureCours(): ?string
    {
        return $this->heureCours;
    }

    public function setHeureCours(string $heureCours): self
    {
        $this->heureCours = $heureCours;

        return $this;
    }

    /**
     * @return Collection<int, Classe>
     */
    public function getClasse(): Collection
    {
        return $this->classe;
    }

    public function addClasse(Classe $classe): self
    {
        if (!$this->classe->contains($classe)) {
            $this->classe[] = $classe;
        }

        return $this;
    }

    public function removeClasse(Classe $classe): self
    {
        $this->classe->removeElement($classe);

        return $this;
    }

    /**
     * @return Collection<int, Etudiant>
     */
    public function getProf(): Collection
    {
        return $this->prof;
    }

    public function addProf(Etudiant $prof): self
    {
        if (!$this->prof->contains($prof)) {
            $this->prof[] = $prof;
        }

        return $this;
    }

    public function removeProf(Etudiant $prof): self
    {
        $this->prof->removeElement($prof);

        return $this;
    }
}
