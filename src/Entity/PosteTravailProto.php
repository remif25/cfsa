<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PosteTravailProtoRepository")
 */
class PosteTravailProto
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=24)
     */
    private $reference;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\PosteTravail", inversedBy="posteTravailProto", cascade={"persist", "remove"})
     */
    private $pdt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPdt(): ?PosteTravail
    {
        return $this->pdt;
    }

    public function setPdt(?PosteTravail $pdt): self
    {
        $this->pdt = $pdt;

        return $this;
    }
}
