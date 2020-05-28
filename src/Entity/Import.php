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
     * @ORM\ManyToOne(targetEntity="App\Entity\Mesure" , cascade={"persist"} )
     */
    private $saisie;

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
}
