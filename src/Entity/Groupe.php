<?php

namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\GroupeRepository;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=GroupeRepository::class)
 */
class Groupe
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $name;


    /**
     * @ORM\Column(type="integer")
     */
    public $number_etu_grp;

    
    /**
     * @Assert\NotBlank
     * @ORM\ManyToOne(targetEntity=Langue::class, inversedBy="Groupe")
     */
    public $Langue;

    /**
     * @ORM\ManyToOne(targetEntity=NiveauScolaire::class, inversedBy="groupes")
     * @ORM\JoinColumn(nullable=false)
     */
    public $Niveau;

    /**
     * @ORM\ManyToOne(targetEntity=Annee::class, inversedBy="groupes")
     * @ORM\JoinColumn(nullable=false)
     */
    public $Annee;

    /**
     * @ORM\OneToMany(targetEntity=Cours::class, mappedBy="Groupe", orphanRemoval=true)
     */
    public $cours;

    /**
     * @ORM\ManyToMany(targetEntity=EmploiDuTemps::class, inversedBy="groupes")
     */
    private $Emploi;


 
    public function __construct()
    {
        $this->cours = new ArrayCollection();
        $this->Emploi = new ArrayCollection();
    }


   public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumberEtuGrp(): ?int
    {
        return $this->number_etu_grp;
    }

    public function setNumberEtuGrp(int $number_etu_grp): self
    {
        $this->number_etu_grp = $number_etu_grp;

        return $this;
    }


    public function getLangue(): ?Langue
    {
        return $this->Langue;
    }

    public function setLangue(?Langue $Langue): self
    {
        $this->Langue = $Langue;

        return $this;
    }
  

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }


    public function getNiveau(): ?NiveauScolaire
    {
        return $this->Niveau;
    }

    public function setNiveau(?NiveauScolaire $Niveau): self
    {
        $this->Niveau = $Niveau;

        return $this;
    }

    public function getAnnee(): ?Annee
    {
        return $this->Annee;
    }

    public function setAnnee(?Annee $Annee): self
    {
        $this->Annee = $Annee;

        return $this;
    }

    /**
     * @return Collection|Cours[]
     */
    public function getCours(): Collection
    {
        return $this->cours;
    }

    public function addCour(Cours $cour): self
    {
        if (!$this->cours->contains($cour)) {
            $this->cours[] = $cour;
            $cour->setGroupe($this);
        }

        return $this;
    }

    public function removeCour(Cours $cour): self
    {
        if ($this->cours->contains($cour)) {
            $this->cours->removeElement($cour);
            // set the owning side to null (unless already changed)
            if ($cour->getGroupe() === $this) {
                $cour->setGroupe(null);
            }
        }

        return $this;
    }



    /**
     * @return Collection|EmploiDuTemps[]
     */
    public function getEmploi(): Collection
    {
        return $this->Emploi;
    }

    public function addEmploi(EmploiDuTemps $emploi): self
    {
        if (!$this->Emploi->contains($emploi)) {
            $this->Emploi[] = $emploi;
        }

        return $this;
    }

    public function removeEmploi(EmploiDuTemps $emploi): self
    {
        if ($this->Emploi->contains($emploi)) {
            $this->Emploi->removeElement($emploi);
        }

        return $this;
    }

    public function __toString() 
    {
        return (string) $this->name;
    }
}
