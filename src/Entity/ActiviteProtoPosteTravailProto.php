<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActiviteProtoPosteTravailProtoRepository")
 */
class ActiviteProtoPosteTravailProto
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ActiviteProto", inversedBy="activiteProtoPosteTravailProtos")
     */
    private $activiteProto;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PosteTravailProto", inversedBy="activiteProtoPosteTravailProtos")
     */
    private $posteTravailProto;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Time", inversedBy="activiteProtoPosteTravailProto", cascade={"persist", "remove"})
     */
    private $time;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getActiviteProto(): ?ActiviteProto
    {
        return $this->activiteProto;
    }

    public function setActiviteProto(?ActiviteProto $activiteProto): self
    {
        $this->activiteProto = $activiteProto;

        return $this;
    }

    public function getPosteTravailProto(): ?PosteTravailProto
    {
        return $this->posteTravailProto;
    }

    public function setPosteTravailProto(?PosteTravailProto $posteTravailProto): self
    {
        $this->posteTravailProto = $posteTravailProto;

        return $this;
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

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'activite' => $this->activiteProto->__toString(),
            'posteTravail' => $this->posteTravailProto->__toString(),
            'time' => $this->getTime() ? $this->getTime()->jsonSerialize() : null
        ];
    }
}
