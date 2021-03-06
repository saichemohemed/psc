<?php

namespace App\Entity;

use App\Repository\NiveauScolaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NiveauScolaireRepository::class)
 */
class NiveauScolaire
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $libelle_niveau;

    /**
     * @ORM\OneToMany(targetEntity=Groupe::class, mappedBy="Niveau", orphanRemoval=true)
     */
    private $groupes;

    public function __construct()
    {
        $this->groupes = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleNiveau(): ?string
    {
        return $this->libelle_niveau;
    }

    public function setLibelleNiveau(string $libelle_niveau): self
    {
        $this->libelle_niveau = $libelle_niveau;

        return $this;
    }

    /**
     * @return Collection|Groupe[]
     */
    public function getGroupes(): Collection
    {
        return $this->groupes;
    }

    public function addGroupe(Groupe $groupe): self
    {
        if (!$this->groupes->contains($groupe)) {
            $this->groupes[] = $groupe;
            $groupe->setNiveau($this);
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupes->contains($groupe)) {
            $this->groupes->removeElement($groupe);
            // set the owning side to null (unless already changed)
            if ($groupe->getNiveau() === $this) {
                $groupe->setNiveau(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->getLibelleNiveau();
    }

}
