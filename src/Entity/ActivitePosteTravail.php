<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActivitePosteTravailRepository")
 */
class ActivitePosteTravail
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Activite", inversedBy="activitePosteTravails")
     */
    private $activite;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PosteTravail", inversedBy="activitePosteTravails")
     */
    private $posteTravail;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $tempsReglage;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $tempsMO;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $tempsMA;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getActivite(): ?Activite
    {
        return $this->activite;
    }

    public function setActivite(?Activite $activite): self
    {
        $this->activite = $activite;

        return $this;
    }

    public function getPosteTravail(): ?PosteTravail
    {
        return $this->posteTravail;
    }

    public function setPosteTravail(?PosteTravail $posteTravail): self
    {
        $this->posteTravail = $posteTravail;

        return $this;
    }

    public function getTempsReglage(): ?float
    {
        return $this->tempsReglage;
    }

    public function setTempsReglage(?float $tempsReglage): self
    {
        $this->tempsReglage = $tempsReglage;

        return $this;
    }

    public function getTempsMO(): ?float
    {
        return $this->tempsMO;
    }

    public function setTempsMO(?float $tempsMO): self
    {
        $this->tempsMO = $tempsMO;

        return $this;
    }

    public function getTempsMA(): ?float
    {
        return $this->tempsMA;
    }

    public function setTempsMA(?float $tempsMA): self
    {
        $this->tempsMA = $tempsMA;

        return $this;
    }
}
