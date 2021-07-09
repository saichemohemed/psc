<?php

namespace App\Entity;

use App\Repository\LangueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass=LangueRepository::class)
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"Langue" = "Langue","CourSoutien" = "CourSoutien","CourNiveau" = "CourNiveau"})
 * @ORM\Table(name="Langue")
 *  @Vich\Uploadable
 */
class Langue
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $langue;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $libelle;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $duree;

    /**
     * @ORM\Column(type="integer")
     */
    protected $prix;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $delais;

    /**
     * @ORM\OneToMany(targetEntity=Groupe::class, mappedBy="Langue")
     */
    protected $Groupe;

        /**
     * @ORM\Column(type="date")
     * @ORM\JoinColumn(nullable=true)
     */
    public $date ;


    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * @Vich\UploadableField(mapping="Langue_img", fileNameProperty="img")
     * @Assert\Image(
     *     mimeTypes = {"image/jpeg", "image/png","image/jpg", "image/gif"},
     *     mimeTypesMessage = "Uniquement .jpeg .png .jpg et .gif Extension valide"
     * ) 
     * @var File
     */
    protected $imageFile;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $img;

    /**
     * @ORM\ManyToMany(targetEntity=Paiement::class, mappedBy="Langue")
     */
    private $paiements;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLangue(): ?string
    {
        return $this->langue;
    }

    public function setLangue(string $langue): self
    {
        $this->langue = $langue;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDuree(): ?\DateTimeInterface
    {
        return $this->duree;
    }

    public function setDuree(\DateTimeInterface $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDelais(): ?string
    {
        return $this->delais;
    }

    public function setDelais(string $delais): self
    {
        $this->delais = $delais;

        return $this;
    }

    public function __construct()
    {
        $this->Groupe = new ArrayCollection();
        $this->paiements = new ArrayCollection();
    }


    /**
     * @return Collection|Groupe[]
     */
    public function getGroupe(): Collection
    {
        return $this->Groupe;
    }

    public function addGroupe(Groupe $Groupe): self
    {
        if (!$this->Groupe->contains($Groupe)) {
            $this->Groupe[] = $Groupe;
            $Groupe->setGroupe($this);
        }

        return $this;
    }

    public function removeGroupe(Groupe $Groupe): self
    {
        if ($this->Groupe->contains($Groupe)) {
            $this->Groupe->removeElement($Groupe);
            // set the owning side to null (unless already changed)
            if ($Groupe->getGroupe() === $this) {
                $Groupe->setGroupe(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getLangue();
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
            $paiement->addLangue($this);
        }

        return $this;
    }

    public function removePaiement(Paiement $paiement): self
    {
        if ($this->paiements->contains($paiement)) {
            $this->paiements->removeElement($paiement);
            $paiement->removeLangue($this);
        }

        return $this;
    }


    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }


/**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $imageFile
     */
  
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        // Only change the updated af if the file is really uploaded to avoid database updates.
        // This is needed when the file should be set when loading the entity.
        if ($this->imageFile instanceof UploadedFile) {
            $this->date = new \DateTime('now');
        }
    }
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImg(?string $img): void
    {
        $this->img = $img;
    }
    
    public function getImg(): ?string
    {
        return $this->img;
    }


}
