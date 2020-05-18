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

   // /**
    // * une salle à potentiellement plusieurs thermo
     //* @ORM\OneToMany(targetEntity="App\Entity\Thermo" , mappedBy="salles")
   //  * @ORM\JoinColumn(name="thermo_id", referencedColumnName="id")
   //  */
   // private $thermo;


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

 //   public function __construct()
   // {
   //     $this->thermo = new ArrayCollection();
   // }

   // /**
    // * @return Collection|Thermo[]
    // */
    //public function getThermo(): Collection
  //  {
    //    return $this->thermo;
  //  }

   // public function addThermo(Thermo $thermo): self
   // {
   //     if (!$this->thermo->contains($thermo)) {
    //        $this->thermo[] = $thermo;
    //        $thermo->setSalles($this);
    //    }

    //    return $this;
    //}

   // public function removeThermo(Thermo $thermo): self
   //{
    //    if ($this->thermo->contains($thermo)) {
    //        $this->thermo->removeElement($thermo);
    //        // set the owning side to null (unless already changed)
    //        if ($thermo->getSalles() === $this) {
     //           $thermo->setSalles(null);
     //       }
     //   }

    //   return $this;
    //}
}
