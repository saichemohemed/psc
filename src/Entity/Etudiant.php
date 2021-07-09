<?php

namespace App\Entity;

use App\Repository\EtudiantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;

/**
 * @ORM\Entity(repositoryClass=EtudiantRepository::class)
 */
class Etudiant extends User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=40)
     */
    protected $nom_pere;

    /**
     * @ORM\Column(type="string", length=40)
     */
    protected $nom_mere;

    /**
     * @ORM\Column(type="string", length=35)
     */
    protected $num_tel_pere;

    /**
     * @ORM\Column(type="string", length=35)
     */
    protected $num_tel_mere;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    protected $profession_pere;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    protected $profession_mere;

    /**
     * @ORM\OneToMany(targetEntity=Cours::class, mappedBy="etudiant", orphanRemoval=true)
     */
    protected $cours;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="etudiant", orphanRemoval=true)
     */
    protected $messages;

    /**
     * @ORM\OneToMany(targetEntity=Paiement::class, mappedBy="etudiant", orphanRemoval=true)
     */
    private $paiements;

    /**
     * @ORM\ManyToMany(targetEntity=Annonce::class, mappedBy="etudiant")
     */
    private $annonces;

    /**
     * @ORM\Column(type="integer")
     */
    private $nb;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbm;

    public function __construct()
    {
        parent::__construct();
        $this->cours = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->paiements = new ArrayCollection();
        $this->annonces = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPere(): ?string
    {
        return $this->nom_pere;
    }

    public function setNomPere(string $nom_pere): self
    {
        $this->nom_pere = $nom_pere;

        return $this;
    }

    public function getNomMere(): ?string
    {
        return $this->nom_mere;
    }

    public function setNomMere(string $nom_mere): self
    {
        $this->nom_mere = $nom_mere;

        return $this;
    }

    public function getNumTelPere(): ?string
    {
        return $this->num_tel_pere;
    }

    public function setNumTelPere(string $num_tel_pere): self
    {
        $this->num_tel_pere = $num_tel_pere;

        return $this;
    }

    public function getNumTelMere(): ?string
    {
        return $this->num_tel_mere;
    }

    public function setNumTelMere(string $num_tel_mere): self
    {
        $this->num_tel_mere = $num_tel_mere;

        return $this;
    }

    public function getProfessionPere(): ?string
    {
        return $this->profession_pere;
    }

    public function setProfessionPere(?string $profession_pere): self
    {
        $this->profession_pere = $profession_pere;

        return $this;
    }

    public function getProfessionMere(): ?string
    {
        return $this->profession_mere;
    }

    public function setProfessionMere(?string $profession_mere): self
    {
        $this->profession_mere = $profession_mere;

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
            $cour->setEtudiant($this);
        }

        return $this;
    }

    public function removeCour(Cours $cour): self
    {
        if ($this->cours->contains($cour)) {
            $this->cours->removeElement($cour);
            // set the owning side to null (unless already changed)
            if ($cour->getEtudiant() === $this) {
                $cour->setEtudiant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setEtudiant($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->contains($message)) {
            $this->messages->removeElement($message);
            // set the owning side to null (unless already changed)
            if ($message->getEtudiant() === $this) {
                $message->setEtudiant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Paiement[]
     */
    public function getPaiements(): Collection
    {
        return $this->paiements;
    }

    public function addPaiement(Paiement $paiement): self
    {
        if (!$this->paiements->contains($paiement)) {
            $this->paiements[] = $paiement;
            $paiement->setEtudiant($this);
        }

        return $this;
    }

    public function removePaiement(Paiement $paiement): self
    {
        if ($this->paiements->contains($paiement)) {
            $this->paiements->removeElement($paiement);
            // set the owning side to null (unless already changed)
            if ($paiement->getEtudiant() === $this) {
                $paiement->setEtudiant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Annonce[]
     */
    public function getAnnonces(): Collection
    {
        return $this->annonces;
    }

    public function addAnnonce(Annonce $annonce): self
    {
        if (!$this->annonces->contains($annonce)) {
            $this->annonces[] = $annonce;
            $annonce->addEtudiant($this);
        }

        return $this;
    }

    public function removeAnnonce(Annonce $annonce): self
    {
        if ($this->annonces->contains($annonce)) {
            $this->annonces->removeElement($annonce);
            $annonce->removeEtudiant($this);
        }

        return $this;
    }

    public function getNb(): ?int
    {
        return $this->nb;
    }

    public function setNb(int $nb): self
    {
        $this->nb = $nb;

        return $this;
    }

    public function getNbm(): ?int
    {
        return $this->nbm;
    }

    public function setNbm(int $nbm): self
    {
        $this->nbm = $nbm;

        return $this;
    }


}
