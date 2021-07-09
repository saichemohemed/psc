<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\EvenementRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * @ORM\Entity(repositoryClass=EvenementRepository::class)
 * @Vich\Uploadable
 */
class Evenement
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=255)
     * @var string|null
     * 
     */
    protected $image;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="Evenement_img", fileNameProperty="image")
     * @Assert\Image(
     *     minWidth = "500",
     *     minWidthMessage = "The image width is too small ({{ width }}px). Minimum width expected is {{ min_width }}px",   
     *     minHeight = "350",
     *     minHeightMessage = "The image height is too small ({{ height }}px). Minimum height expected is {{ min_height }}px",
     *     mimeTypes = {"image/jpeg", "image/png","image/jpg", "image/gif"},
     *     mimeTypesMessage = "Uniquement .jpeg .png .jpg et .gif Extension valide"
     * ) 
     * @var File|null
     */
    protected $imageFile;



    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $titre_evenement;

    /**
     * @ORM\Column(type="datetime")
     *  @var \DateTime|null
     */
    protected $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $delais;

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



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreEvenement(): ?string
    {
        return $this->titre_evenement;
    }

    public function setTitreEvenement(string $titre_evenement): self
    {
        $this->titre_evenement = $titre_evenement;

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

    public function getDelais(): ?string
    {
        return $this->delais;
    }

    public function setDelais(string $delais): self
    {
        $this->delais = $delais;

        return $this;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }




}
