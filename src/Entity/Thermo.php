<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Salle;
/**
 * @ORM\Entity(repositoryClass="App\Repository\ThermoRepository")
 */
class Thermo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="integer")
     */
    private $temperature;

    /**
     * @ORM\Column(type="integer")
     */
    private $hygrometrie;

   // /**
    //* Un thermo est lié a une salle
    // * @ORM\ManyToMany(targetEntity="App\Entity\Salle", mappedBy="thermo")
    // */
   // private $salles;


    public function getId(): ?int
    {
        return $this->id;
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

    public function getTemperature(): ?int
    {
        return $this->temperature;
    }

    public function setTemperature(int $temperature): self
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function getHygrometrie(): ?int
    {
        return $this->hygrometrie;
    }

    public function setHygrometrie(int $hygrometrie): self
    {
        $this->hygrometrie = $hygrometrie;

        return $this;
    }

  //  public function __construct()
   // {
   //     $this->salles=new ArrayCollection();
   // }

  //  /**
   //  * @return Collection|Salle[]
   //  */
  //  public function getSalles(): Collection
   // {
   //     return $this->salles;
    //}

   // public function addSalle(Salle $salle): self
   // {
    //    if (!$this->salles->contains($salle)) {
    //        $this->salles[] = $salle;
    //        $salle->addThermo($this);


       // return $this;
 //   }

 //   public function removeSalle(Salle $salle): self
 //   {
 //       if ($this->salles->contains($salle)) {
  //          $this->salles->removeElement($salle);
  //          $salle->removeThermo($this);
   //     }

    //    return $this;
   // }
}
