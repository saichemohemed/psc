<?php

namespace App\Entity;

use App\Repository\AnneeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnneeRepository::class)
 */
class Annee
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

  

    /**
     * @ORM\Column(type="date")
     */
    private $annee_scolaire_D;

    /**
     * @ORM\Column(type="date")
     */
    private $annee_scolaire_F;
    
  /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    public $libelle_niveau ;



    /**
     * @ORM\OneToMany(targetEntity=Groupe::class, mappedBy="Annee", orphanRemoval=true)
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

    public function getAnneeScolaireD(): ?\DateTimeInterface
    {
        return $this->annee_scolaire_D;
    }

    public function setAnneeScolaireD(\DateTimeInterface $annee_scolaire_D): self
    {
        $this->annee_scolaire_D = $annee_scolaire_D;

        return $this;
    }

    public function getAnneeScolaireF(): ?\DateTimeInterface
    {
        return $this->annee_scolaire_F;
    }

    public function setAnneeScolaireF(\DateTimeInterface $annee_scolaire_F): self
    {
        $this->annee_scolaire_F = $annee_scolaire_F;

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
            $groupe->setAnnee($this);
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupes->contains($groupe)) {
            $this->groupes->removeElement($groupe);
            // set the owning side to null (unless already changed)
            if ($groupe->getAnnee() === $this) {
                $groupe->setAnnee(null);
            }
        }

        return $this;
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
    public function __toString()
    {
        return $this->getLibelleNiveau();
    }

}
