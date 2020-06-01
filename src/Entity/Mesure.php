<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MesureRepository")
 */
class Mesure
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

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Salle", inversedBy="mesure")
     * @ORM\JoinColumn(nullable=false)
     */

    private $salle;

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

    /**
     * @return mixed
     */
    public function getSalle()
    {
        return $this->salle;
    }

    /**
     * @param mixed $salle
     */
    public function setSalle($salle): void
    {
        $this->salle = $salle;

    }

}
