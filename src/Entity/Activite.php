<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActiviteRepository")
 */
class Activite implements JsonSerializable
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
     * @ORM\OneToMany(targetEntity="App\Entity\Operation", mappedBy="activite", orphanRemoval=true)
     */
    private $operations;


    private $pdts;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ActiviteProto", mappedBy="activite")
     */
    private $activiteProto;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ActivitePosteTravail", mappedBy="activite", cascade={"persist", "remove"}, fetch="EAGER")
     */
    private $activitePosteTravails;

    public function __construct()
    {
        $this->operations = new ArrayCollection();
        $this->pdts = new ArrayCollection();
        $this->activitePosteTravails = new ArrayCollection();
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

    /**
     * @return Collection|Operation[]
     */
    public function getOperations(): Collection
    {
        return $this->operations;
    }

    public function addOperation(Operation $operation): self
    {
        if (!$this->operations->contains($operation)) {
            $this->operations[] = $operation;
            $operation->setActivite($this);
        }

        return $this;
    }

    public function removeOperation(Operation $operation): self
    {
        if ($this->operations->contains($operation)) {
            $this->operations->removeElement($operation);
            // set the owning side to null (unless already changed)
            if ($operation->getActivite() === $this) {
                $operation->setActivite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PosteTravail[]
     */
    /*public function getPdts(): Collection
    {
        $posteTravail = new ArrayCollection();
        foreach ($this->activitePosteTravails as $activitePosteTravail) {
            $posteTravail->add($activitePosteTravail->getPosteTravail());
        }

        return $posteTravail;
    }

    public function addPdt(PosteTravail $pdt): self
    {
        $activitePosteTravail = new ActivitePosteTravail();
        $activitePosteTravail->setPosteTravail($pdt);
        $activitePosteTravail->setActivite($this);

        return $this;
    }

    public function removePdt(PosteTravail $pdt): self
    {

        foreach ($this->activitePosteTravails as $activitePosteTravail) {
            if($activitePosteTravail->getPosteTravail() == $pdt) {
            }
            $posteTravail[] = $this->activitePosteTravails->getPosteTravail();
        }
        if ($this->pdts->contains($pdt)) {
            $this->pdts->removeElement($pdt);
        }

        return $this;
    }*/

    public function __toString() {
        return $this->reference . ' - ' . $this->description;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'reference' => $this->getReference(),
            'description' => $this->getDescription(),
            'text' => $this->__toString()
        ];
    }

    public function getActiviteProto(): ?ActiviteProto
    {
        return $this->activiteProto;
    }

    public function setActiviteProto(?ActiviteProto $activiteProto): self
    {
        $this->activiteProto = $activiteProto;

        // set (or unset) the owning side of the relation if necessary
        $newActivite = null === $activiteProto ? null : $this;
        if ($activiteProto->getActivite() !== $newActivite) {
            $activiteProto->setActivite($newActivite);
        }

        return $this;
    }

    /**
     * @return Collection|ActivitePosteTravail[]
     */
    public function getActivitePosteTravails(): Collection
    {
        return $this->activitePosteTravails;
    }

    public function addActivitePosteTravail(ActivitePosteTravail $activitePosteTravail): self
    {
        if (!$this->activitePosteTravails->contains($activitePosteTravail)) {
            $this->activitePosteTravails[] = $activitePosteTravail;
            $activitePosteTravail->setActivite($this);
        }

        return $this;
    }

    public function removeActivitePosteTravail(ActivitePosteTravail $activitePosteTravail): self
    {
        if ($this->activitePosteTravails->contains($activitePosteTravail)) {
            $this->activitePosteTravails->removeElement($activitePosteTravail);
            // set the owning side to null (unless already changed)
            if ($activitePosteTravail->getActivite() === $this) {
                $activitePosteTravail->setActivite(null);
            }
        }

        return $this;
    }
}
