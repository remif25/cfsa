<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\OneToOne(targetEntity="App\Entity\PosteTravail", inversedBy="posteTravailProto")
     */
    private $pdt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CentreProduction", inversedBy="pdtsproto")
     */
    private $centreProduction;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\ActiviteProto", inversedBy="posteTravailProtos")
     */
    private $activitesproto;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ActiviteProtoPosteTravailProto", mappedBy="posteTravailProto")
     */
    private $activiteProtoPosteTravailProtos;

    public function __construct()
    {
        $this->activitesproto = new ArrayCollection();
        $this->activiteProtoPosteTravailProtos = new ArrayCollection();
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

    public function getPdt(): ?PosteTravail
    {
        return $this->pdt;
    }

    public function setPdt(?PosteTravail $pdt): self
    {
        $this->pdt = $pdt;

        return $this;
    }

    public function getCentreProduction(): ?CentreProduction
    {
        return $this->centreProduction;
    }

    public function setCentreProduction(?CentreProduction $centreProduction): self
    {
        $this->centreProduction = $centreProduction;

        return $this;
    }

    public function __toString() {
        return $this->reference . ' - ' . $this->description;
    }

    /**
     * @return Collection|ActiviteProto[]
     */
    public function getActivitesproto(): Collection
    {
        return $this->activitesproto;
    }

    public function addActivitesproto(ActiviteProto $activitesproto): self
    {
        if (!$this->activitesproto->contains($activitesproto)) {
            $this->activitesproto[] = $activitesproto;
        }

        return $this;
    }

    public function removeActivitesproto(ActiviteProto $activitesproto): self
    {
        if ($this->activitesproto->contains($activitesproto)) {
            $this->activitesproto->removeElement($activitesproto);
        }

        return $this;
    }

    /**
     * @return Collection|ActiviteProtoPosteTravailProto[]
     */
    public function getActiviteProtoPosteTravailProtos(): Collection
    {
        return $this->activiteProtoPosteTravailProtos;
    }

    public function addActiviteProtoPosteTravailProto(ActiviteProtoPosteTravailProto $activiteProtoPosteTravailProto): self
    {
        if (!$this->activiteProtoPosteTravailProtos->contains($activiteProtoPosteTravailProto)) {
            $this->activiteProtoPosteTravailProtos[] = $activiteProtoPosteTravailProto;
            $activiteProtoPosteTravailProto->setPosteTravailProto($this);
        }

        return $this;
    }

    public function removeActiviteProtoPosteTravailProto(ActiviteProtoPosteTravailProto $activiteProtoPosteTravailProto): self
    {
        if ($this->activiteProtoPosteTravailProtos->contains($activiteProtoPosteTravailProto)) {
            $this->activiteProtoPosteTravailProtos->removeElement($activiteProtoPosteTravailProto);
            // set the owning side to null (unless already changed)
            if ($activiteProtoPosteTravailProto->getPosteTravailProto() === $this) {
                $activiteProtoPosteTravailProto->setPosteTravailProto(null);
            }
        }

        return $this;
    }
}
