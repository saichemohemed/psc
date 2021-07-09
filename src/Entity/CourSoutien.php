<?php

namespace App\Entity;

use App\Repository\CourSoutienRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Langue;


/**
 * @ORM\Entity(repositoryClass=CourSoutienRepository::class)
 */
class CourSoutien extends Langue
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity=Specialite::class, inversedBy="courSoutiens")
     */
    private $Specialit;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSpecialit(): ?Specialite
    {
        return $this->Specialit;
    }

    public function setSpecialit(?Specialite $Specialit): self
    {
        $this->Specialit = $Specialit;

        return $this;
    }

    

}
