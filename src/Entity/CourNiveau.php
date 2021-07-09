<?php

namespace App\Entity;

use App\Repository\CourNiveauRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Langue;


/**
 * @ORM\Entity(repositoryClass=CourNiveauRepository::class)
 */
class CourNiveau extends Langue
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    public function getId(): ?int
    {
        return $this->id;
    }
    

}
