<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActiviteProtoRepository")
 */
class ActiviteProto
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $reference;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Activite", inversedBy="activiteProto", cascade={"persist", "remove"})
     */
    private $activite;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\PosteTravailProto", mappedBy="activitesproto")
     */
    private $posteTravailProtos;

    public function __construct()
    {
        $this->posteTravailProtos = new ArrayCollection();
    }

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

    public function getActivite(): ?Activite
    {
        return $this->activite;
    }

    public function setActivite(?Activite $activite): self
    {
        $this->activite = $activite;

        return $this;
    }

    public function __toString() {
        return $this->reference . ' - ' . $this->description;
    }

    /**
     * @return Collection|PosteTravailProto[]
     */
    public function getPosteTravailProtos(): Collection
    {
        return $this->posteTravailProtos;
    }

    public function addPosteTravailProto(PosteTravailProto $posteTravailProto): self
    {
        if (!$this->posteTravailProtos->contains($posteTravailProto)) {
            $this->posteTravailProtos[] = $posteTravailProto;
            $posteTravailProto->addActivitesproto($this);
        }

        return $this;
    }

    public function removePosteTravailProto(PosteTravailProto $posteTravailProto): self
    {
        if ($this->posteTravailProtos->contains($posteTravailProto)) {
            $this->posteTravailProtos->removeElement($posteTravailProto);
            $posteTravailProto->removeActivitesproto($this);
        }

        return $this;
    }
}
