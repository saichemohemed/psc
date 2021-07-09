<?php
// src/Entity/User.php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @UniqueEntity(fields={"phone"}, message="ce numero de telephone est deja existe")
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"User" = "User","Etudiant" = "Etudiant","Admin" = "Admin"})
 * @ORM\Table(name="user")
 * @Vich\Uploadable
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="user_img", fileNameProperty="imageName")
     *  @Assert\Image(
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
     * @ORM\Column(type="string", length=255)
     *
     * @var string
      */
    protected $imageName;

     /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime|null
     */
    public  $updatedAt;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $imagePath;

    /**
     * @ORM\Column(type="string", length=150)
     */
    protected $lastName;

    /**
     * @ORM\Column(type="string", length=150)
     */
    protected $firstName;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $birthDate;

    /**
     
     *
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    protected $birthPlace;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $address;

    /**
     * @ORM\Column(type="string", length=70, nullable=true)
     */
    protected $gender;

    /**
     * @ORM\Column(type="string", length=35, nullable=true)
     * @Assert\Type(type="numeric", message="Le téléphone  doit être un nombre.")
    * @Assert\Length(
     *     min = 10,
     *      max = 10,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
    * )
     */
    protected $phone;

    /**
     * 
     * Date/Time of the last activity
	 *
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $lastActivity;

    /**
     * Date/Time of the first Login Today
	 *
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $firstLoginToday;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datecreated;

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
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }
    

  
    public function getimagePath(): ?string
    {
        return $this->imagePath;
    }

    public function setimagePath(?string $imagePath): self
    {
        $this->imagePath = $imagePath;

        return $this;
    }


    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }
    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getBirthPlace(): ?string
    {
        return $this->birthPlace;
    }

    public function setBirthPlace(?string $birthPlace): self
    {
        $this->birthPlace = $birthPlace;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getLastActivity(): ?\DateTimeInterface
    {
        return $this->lastActivity;
    }

    public function setLastActivity(?\DateTimeInterface $lastActivity): self
    {
        $this->lastActivity = $lastActivity;

        return $this;
    }
    

    public function getFirstLoginToday(): ?\DateTimeInterface
    {
        return $this->firstLoginToday;
    }

    public function setFirstLoginToday(?\DateTimeInterface $firstLoginToday): self
    {
        $this->firstLoginToday = $firstLoginToday;

        return $this;
    }

    public function getDatecreated(): ?\DateTimeInterface
    {
        return $this->datecreated;
    }

    public function setDatecreated(\DateTimeInterface $datecreated): self
    {
        $this->datecreated = $datecreated;

        return $this;
    }

  
}