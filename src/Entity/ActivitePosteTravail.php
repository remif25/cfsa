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
     * @ORM\ManyToOne(targetEntity="App\Entity\Activite", inversedBy="activitePosteTravails", fetch="EAGER")
     */
    private $activite;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PosteTravail", inversedBy="activitePosteTravails", fetch="EAGER")
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

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $acheminement;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $quantite;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $unite;

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

    public function __toString() {
        return $this->activite->__toString() . ' //  ' . $this->posteTravail->__toString();
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'activite' => $this->activite->__toString(),
            'posteTravail' => $this->posteTravail->__toString(),
            'tempsReglage' => $this->tempsReglage,
            'tempsMO' => $this->tempsMO,
            'tempsMA' => $this->tempsMA
        ];
    }

    public function getAcheminement(): ?int
    {
        return $this->acheminement;
    }

    public function setAcheminement(?int $acheminement): self
    {
        $this->acheminement = $acheminement;

        return $this;
    }

    public function getQuantite(): ?float
    {
        return $this->quantite;
    }

    public function setQuantite(?float $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getUnite(): ?string
    {
        return $this->unite;
    }

    public function setUnite(?string $unite): self
    {
        $this->unite = $unite;

        return $this;
    }
}
