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
     * @ORM\OneToOne(targetEntity="App\Entity\Time", inversedBy="activitePosteTravail", cascade={"persist", "remove"})
     */
    private $time;


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

    public function __toString() {
        return $this->activite->__toString() . ' //  ' . $this->posteTravail->__toString();
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'activite' => $this->activite->__toString(),
            'posteTravail' => $this->posteTravail->__toString(),
            'time' => $this->getTime() ? $this->getTime()->jsonSerialize() : null
        ];
    }

    public function getTime(): ?Time
    {
        return $this->time;
    }

    public function setTime(?Time $time): self
    {
        $this->time = $time;

        return $this;
    }

}
