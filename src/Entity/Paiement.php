<?php

namespace App\Entity;

use App\Repository\PaiementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=PaiementRepository::class)
 *  @Vich\Uploadable
 */
class Paiement
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     *    @ORM\JoinColumn(nullable=true)
     */
    private $mantent;

    /**
     * @ORM\Column(type="date")
     * @ORM\JoinColumn(nullable=true)
     */
    public $date_paiement ;

    /**
     * @ORM\Column(type="string", length=255)
     * @ORM\JoinColumn(nullable=true)
     */
    private $paye_paiement;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $URL_mondat ;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * @Assert\NotBlank

     * @Vich\UploadableField(mapping="paiement_img", fileNameProperty="URL_mondat")
     * @Assert\Image(
     *     minWidth = "500",
     *     minWidthMessage = "The image width is too small ({{ width }}px). Minimum width expected is {{ min_width }}px",   
     *     minHeight = "350",
     *     minHeightMessage = "The image height is too small ({{ height }}px). Minimum height expected is {{ min_height }}px",
     *     mimeTypes = {"image/jpeg", "image/png","image/jpg", "image/gif"},
     *     mimeTypesMessage = "Uniquement .jpeg .png .jpg et .gif Extension valide"
     * ) 
     * @var File
     */
    protected $imageFile;


    /**
     * @ORM\ManyToOne(targetEntity=Etudiant::class, inversedBy="paiements")
     * @ORM\JoinColumn(nullable=false)
     */
    public $etudiant;

 

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Remarque;

    /**
     * @ORM\ManyToMany(targetEntity=Langue::class, inversedBy="paiements")
     */
    private $Langue;

    public function __construct()
    {
        $this->Langue = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMantent(): ?int
    {
        return $this->mantent;
    }

    public function setMantent(int $mantent): self
    {
        $this->mantent = $mantent;

        return $this;
    }



    public function getDatePaiement(): ?\DateTimeInterface
    {
        return $this->date_paiement;
    }

    public function setDatePaiement(\DateTimeInterface $date_paiement): self
    {
        $this->date_paiement = $date_paiement;

        return $this;
    }

    public function getPayePaiement(): ?string
    {
        return $this->paye_paiement;
    }

    public function setPayePaiement(string $paye_paiement): self
    {
        $this->paye_paiement = $paye_paiement;

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
            $this->date_paiement = new \DateTime('now');
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setURLMondat(?string $URL_mondat): void
    {
        $this->URL_mondat = $URL_mondat;
    }
    
    public function getURLMondat(): ?string
    {
        return $this->URL_mondat;
    }


    public function getEtudiant(): ?Etudiant
    {
        return $this->etudiant;
    }

    public function setEtudiant(?Etudiant $etudiant): self
    {
        $this->etudiant = $etudiant;

        return $this;
    }

    public function __toString() 
    {
        return (string) $this->id;
    }


    public function getRemarque(): ?string
    {
        return $this->Remarque;
    }

    public function setRemarque(?string $Remarque): self
    {
        $this->Remarque = $Remarque;

        return $this;
    }

    /**
     * @return Collection|Langue[]
     */
    public function getLangue(): Collection
    {
        return $this->Langue;
    }

    public function addLangue(Langue $langue): self
    {
        if (!$this->Langue->contains($langue)) {
            $this->Langue[] = $langue;
        }

        return $this;
    }

    public function removeLangue(Langue $langue): self
    {
        if ($this->Langue->contains($langue)) {
            $this->Langue->removeElement($langue);
        }

        return $this;
    }

}
