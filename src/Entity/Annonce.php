<?php

namespace App\Entity;

use App\Repository\AnnonceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnnonceRepository::class)
 */
class Annonce
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public $texte_annonce;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public $titre_annonce;

    /**
     * @ORM\ManyToMany(targetEntity=etudiant::class, inversedBy="annonces")
     */
    private $etudiant;

    /**
     * @ORM\Column(type="datetime")
     */
    private $Date;


    public function __construct()
    {
        $this->etudiant = new ArrayCollection();
    }

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTexteAnnonce(): ?string
    {
        return $this->texte_annonce;
    }

    public function setTexteAnnonce(string $texte_annonce): self
    {
        $this->texte_annonce = $texte_annonce;

        return $this;
    }

    public function getTitreAnnonce(): ?string
    {
        return $this->titre_annonce;
    }

    public function setTitreAnnonce(string $titre_annonce): self
    {
        $this->titre_annonce = $titre_annonce;

        return $this;
    }

    /**
     * @return Collection|etudiant[]
     */
    public function getEtudiant(): Collection
    {
        return $this->etudiant;
    }

    public function addEtudiant(etudiant $etudiant): self
    {
        if (!$this->etudiant->contains($etudiant)) {
            $this->etudiant[] = $etudiant;
        }

        return $this;
    }

    public function removeEtudiant(etudiant $etudiant): self
    {
        if ($this->etudiant->contains($etudiant)) {
            $this->etudiant->removeElement($etudiant);
        }

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): self
    {
        $this->Date = $Date;

        return $this;
    }



 
}
