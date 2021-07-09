<?php

namespace App\Entity;

use App\Repository\SpecialiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SpecialiteRepository::class)
 */
class Specialite
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    public $nom_specialite;

    /**
     * @ORM\OneToMany(targetEntity=CourSoutien::class, mappedBy="Specialit")
     */
    private $courSoutiens;

    public function __construct()
    {
        $this->courSoutiens = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomSpecialite(): ?string
    {
        return $this->nom_specialite;
    }

    public function setNomSpecialite(string $nom_specialite): self
    {
        $this->nom_specialite = $nom_specialite;

        return $this;
    }


    /**
     * @return Collection|CourSoutien[]
     */
    public function getCourSoutiens(): Collection
    {
        return $this->courSoutiens;
    }

    public function addCourSoutien(CourSoutien $courSoutien): self
    {
        if (!$this->courSoutiens->contains($courSoutien)) {
            $this->courSoutiens[] = $courSoutien;
            $courSoutien->setSpecialit($this);
        }

        return $this;
    }

    public function removeCourSoutien(CourSoutien $courSoutien): self
    {
        if ($this->courSoutiens->contains($courSoutien)) {
            $this->courSoutiens->removeElement($courSoutien);
            // set the owning side to null (unless already changed)
            if ($courSoutien->getSpecialit() === $this) {
                $courSoutien->setSpecialit(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->getNomSpecialite();
    }
}
