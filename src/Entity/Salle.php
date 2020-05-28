<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Thermo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass="App\Repository\SalleRepository")
 * @UniqueEntity("nom")
 */
class Salle
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     *
     */
    private $nom;


    /**
    /* une salle à plusieurs mesures et on se donne le droit de créer une salle sans mesure
    /* @ORM\OneToOne(targetEntity="App\Entity\Mesure" , cascade={"persist"} )
     */
    private $mesure;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function setMesure(Mesure $mesure = null){
        $this->mesure = $mesure;
    }


    public function getMesure()
    {
        return $this->mesure;
    }
}
