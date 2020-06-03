<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImportRepository")
 */
class Import
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $saisie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Salle", inversedBy="import")
     * @ORM\JoinColumn(nullable=false)
     */

    private $salle;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSaisie(): ?string
    {
        return $this->saisie;
    }

    public function setSaisie(string $saisie): self
    {
        $this->saisie = $saisie;

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
