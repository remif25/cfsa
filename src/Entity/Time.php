<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TimeRepository")
 */
class Time
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

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
     * @ORM\OneToOne(targetEntity="App\Entity\ActivitePosteTravail", mappedBy="time", cascade={"persist", "remove"})
     */
    private $activitePosteTravail;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ActiviteProtoPosteTravailProto", mappedBy="time", cascade={"persist", "remove"})
     */
    private $activiteProtoPosteTravailProto;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Unite", inversedBy="times")
     */
    private $unite;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAcheminement(): ?float
    {
        return $this->acheminement;
    }

    public function setAcheminement(?float $acheminement): self
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

    public function getActivitePosteTravail(): ?ActivitePosteTravail
    {
        return $this->activitePosteTravail;
    }

    public function setActivitePosteTravail(?ActivitePosteTravail $activitePosteTravail): self
    {
        $this->activitePosteTravail = $activitePosteTravail;

        // set (or unset) the owning side of the relation if necessary
        $newTime = null === $activitePosteTravail ? null : $this;
        if ($activitePosteTravail->getTime() !== $newTime) {
            $activitePosteTravail->setTime($newTime);
        }

        return $this;
    }

    public function getActiviteProtoPosteTravailProto(): ?ActiviteProtoPosteTravailProto
    {
        return $this->activiteProtoPosteTravailProto;
    }

    public function setActiviteProtoPosteTravailProto(?ActiviteProtoPosteTravailProto $activiteProtoPosteTravailProto): self
    {
        $this->activiteProtoPosteTravailProto = $activiteProtoPosteTravailProto;

        // set (or unset) the owning side of the relation if necessary
        $newTime = null === $activiteProtoPosteTravailProto ? null : $this;
        if ($activiteProtoPosteTravailProto->getTime() !== $newTime) {
            $activiteProtoPosteTravailProto->setTime($newTime);
        }

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'tempsReglage' => $this->tempsReglage->__toString(),
            'tempsMO' => $this->tempsMO->__toString(),
            'tempsMA' => $this->tempsMA->__toString(),
            'acheminement' => $this->acheminement->__toString(),
            'quantite' => $this->quantite->__toString(),
            'unite' => $this->unite
        ];
    }

    public function getUnite(): ?Unite
    {
        return $this->unite;
    }

    public function setUnite(?Unite $unite): self
    {
        $this->unite = $unite;

        return $this;
    }
}
